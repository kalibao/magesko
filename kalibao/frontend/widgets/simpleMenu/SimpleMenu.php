<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\widgets\simpleMenu;

use kalibao\common\components\cms\CmsMenuSimpleService;
use Yii;
use kalibao\common\models\cmsSimpleMenu\CmsSimpleMenu;
use yii\caching\TagDependency;

/**
 * Class SimpleMenu provides a widget to display a simple cms menu
 *
 * @package kalibao\frontend\widgets\simpleMenu\SimpleMenu
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class SimpleMenu extends \yii\base\Widget
{
    /**
     * @var int Menu group ID
     */
    public $menuGroupId;

    /**
     * @var array Models
     */
    protected $models;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->menuGroupId === null) {
            throw new \yii\base\InvalidParamException();
        }

        $this->models = CmsSimpleMenu::getDb()->cache(
            function ($db) {
                return CmsSimpleMenu::find()
                    ->innerJoinWith([
                        'cmsSimpleMenuI18ns' => function ($query) {
                            $query->where(['i18n_id' => Yii::$app->language]);
                        }
                    ])
                    ->where([
                        'cms_simple_menu_group_id' => $this->menuGroupId
                    ])
                    ->orderBy('position')
                    ->asArray()
                    ->all();
            },
            0,
            new TagDependency([
                'tags' => [
                    CmsMenuSimpleService::getCacheTag(),
                    CmsMenuSimpleService::getCacheTag($this->menuGroupId),
                ],
            ])
        );
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $html = '
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">';

        foreach ($this->models as $model) {
            $html .= '<li><a href="'.$model['cmsSimpleMenuI18ns'][0]['url'].'">'.$model['cmsSimpleMenuI18ns'][0]['title'].'</a></li>';
        }

        $html .= '
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>';

        return $html;
    }
}