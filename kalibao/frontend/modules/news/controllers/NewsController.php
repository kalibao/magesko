<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\news\controllers;

use Yii;
use kalibao\common\models\cmsNews\CmsNews;
use kalibao\common\components\cms\CmsContentBehavior;
use kalibao\frontend\components\web\Controller;
use yii\data\Pagination;

/**
 * Class NewsController
 *
 * @package kalibao\frontend\modules\news\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            CmsContentBehavior::className()
        ];
    }

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        // page size
        $pageSize = 2;

        // main query
        $query = CmsNews::find()
            ->innerJoinWith([
                'cmsNewsI18ns' => function ($query) {
                    $query->where([
                        'i18n_id' => Yii::$app->language,
                    ]);
                }
            ])
            ->where([
                'cms_news_group_id' => 2,
                'activated' => 1,
            ]);

        // count query
        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $pageSize,
            'defaultPageSize' => $pageSize
        ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['published_at' => SORT_DESC])
            ->all();

        return $this->render($this->renderView, ['models' => $models, 'pages' => $pages]);
    }
}
