<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\cms;

use Yii;
use yii\base\Behavior;
use yii\caching\TagDependency;
use yii\web\HttpException;
use kalibao\common\components\web\Controller;
use kalibao\common\models\cmsPage\CmsPage;
use kalibao\common\components\cms\CmsPageService as CmsPageComponent;
use kalibao\common\models\cmsPageContent\CmsPageContent;
use kalibao\common\models\cmsWidget\CmsWidget;

/**
 * Class CmsContentBehavior provides a behavior to find pages
 *
 * @package kalibao\frontend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsContentBehavior extends Behavior
{
    /**
     * @var string Slug parameter
     */
    public $slugParam = 'cms_slug';

    /**
     * @var string Render view
     */
    public $renderView;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    /**
     * Find page
     * @throws HttpException
     */
    public function beforeAction()
    {
        // request
        $request = Yii::$app->request;

        if ($slugParam = $request->get($this->slugParam, false)) {
            // controller
            $controller = Yii::$app->controller;

            // view
            $view = $controller->view;
            // cache key
            $cacheKey = 'cms_page_slug:' . $slugParam . ':' . Yii::$app->language;

            // get from cache
            if (($dataPage = Yii::$app->commonCache->get($cacheKey)) === false) {
                $cmsPage = CmsPage::find()
                    ->innerJoinWith([
                        'cmsPageI18ns' => function ($query) use ($slugParam) {
                            $query->where([
                                'slug' => $slugParam,
                                'i18n_id' => Yii::$app->language,
                            ]);
                        },
                        'cmsLayout'
                    ])
                    ->where(['activated' => 1])
                    ->asArray()
                    ->one();


                if ($cmsPage !== null && isset($cmsPage['cmsPageI18ns'][0])) {
                    $cmsPageContents = CmsPageContent::find()
                        ->innerJoinWith([
                            'cmsPageContentI18ns' => function ($query) {
                                $query->where([
                                    'i18n_id' => Yii::$app->language,
                                ]);
                            },
                        ])
                        ->where(['cms_page_id' => $cmsPage['id']])
                        ->orderBy(['index' => SORT_ASC])
                        ->asArray()
                        ->all();

                    Yii::$app->commonCache->set(
                        $cacheKey,
                        [
                            'cmsPage' => $cmsPage,
                            'cmsPageContents' => $cmsPageContents
                        ],
                        $cmsPage['cache_duration'],
                        new TagDependency([
                            'tags' => [
                                CmsPageComponent::getCacheTag(),
                                CmsPageComponent::getCacheTag($cmsPage['id']),
                                CmsPageComponent::getCacheTag(
                                    $cmsPage['id'],
                                    $cmsPage['cmsPageI18ns'][0]['slug'],
                                    Yii::$app->language
                                ),
                            ],
                        ])
                    );
                }
            } else {
                $cmsPage = $dataPage['cmsPage'];
                $cmsPageContents = $dataPage['cmsPageContents'];
            }

            if (!empty($cmsPage) && !empty($cmsPageContents)) {
                $view->title = $cmsPage['cmsPageI18ns'][0]['html_title'];
                if ($cmsPage['cmsPageI18ns'][0]['html_description'] != '') {
                    $view->registerMetaTag([
                        'name' => 'description',
                        'content' => $cmsPage['cmsPageI18ns'][0]['html_description']
                    ]);
                }
                if ($cmsPage['cmsPageI18ns'][0]['html_keywords'] != '') {
                    $view->registerMetaTag([
                        'name' => 'keywords',
                        'content' => $cmsPage['cmsPageI18ns'][0]['html_keywords']
                    ]);
                }

                $controller->layout = $cmsPage['cmsLayout']['path'];
                $this->renderView = $cmsPage['cmsLayout']['view'];

                $this->parseCmsPageContents($cmsPageContents);

                foreach ($cmsPageContents as &$cmsPageContent) {
                    if (isset($cmsPageContent['cmsPageContentI18ns'][0])) {
                        $view->blocks['cms_block_page_'.$cmsPageContent['index']] =
                            $cmsPageContent['cmsPageContentI18ns'][0]['content'];
                    }
                }
            } else {
                throw new HttpException(404);
            }
        } else {
            throw new HttpException(404);
        }
    }

    /**
     * Parse cms page contents
     * @param array $cmsPageContents
     */
    protected function parseCmsPageContents(array &$cmsPageContents)
    {
        foreach ($cmsPageContents as &$cmsPageContent) {
            if (isset($cmsPageContent['cmsPageContentI18ns'][0])) {
                $cmsPageContent['cmsPageContentI18ns'][0]['content'] = $this->parseWidget($cmsPageContent['cmsPageContentI18ns'][0]['content']);
            }
        }
    }

    /**
     * Parse Widget
     * @param string $html Html to parse
     * @return mixed
     */
    protected function parseWidget($html)
    {
        $list = array();
        preg_match_all("#\<cms_widget id=\"(.*)\">(.*)</cms_widget>#msU", $html, $list, PREG_SET_ORDER);
        $find = [];
        $replace = [];

        foreach ($list as $function) {
            // cache key
            $cacheKey = 'cms_widget_id:' . $function[1];
            // get model from cache
            if (($widgetModel = Yii::$app->commonCache->get($cacheKey)) === false) {
                $widgetModel = CmsWidget::find()->where(['id' => $function[1]])->asArray()->one();
                Yii::$app->commonCache->set(
                    $cacheKey,
                    $widgetModel,
                    CmsWidgetService::$cacheDuration,
                    new TagDependency([
                        'tags' => [
                            CmsWidgetService::getCacheTag(),
                            CmsWidgetService::getCacheTag($function[1])
                        ],
                    ])
                );
            }

            if ($widgetModel !== null) {
                $arg = json_decode($widgetModel['arg'], true);
                if($arg === null) {
                    $arg = [];
                }
                $widget = $widgetModel['path'];
                $find[] = '<cms_widget id="'.$function[1].'">'.$function[2].'</cms_widget>';
                $replace[] = $widget::widget($arg);
            }
        }

        return str_replace($find, $replace, $html);
    }

}