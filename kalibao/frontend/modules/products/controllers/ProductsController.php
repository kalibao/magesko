<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\products\controllers;

use kalibao\common\components\cms\CmsPageService;
use kalibao\common\models\product\Product;
use Yii;
use kalibao\common\models\cmsNews\CmsNews;
use kalibao\common\components\cms\CmsContentBehavior;
use kalibao\frontend\components\web\Controller;
use yii\base\InvalidParamException;
use yii\data\Pagination;

/**
 * Class ProductsController
 *
 * @package kalibao\frontend\modules\products\controllers
 * @version 1.0
 */
class ProductsController extends Controller
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
        $query = Product::find()
            ->innerJoinWith([
                'productI18ns' => function ($query) {
                    $query->where([
                        'i18n_id' => Yii::$app->language,
                    ]);
                }
            ])
            ->where([
                'archived' => 0,
            ]);

        // count query
        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $pageSize,
            'defaultPageSize' => $pageSize
        ]);

        $productUrl = '/' . CmsPageService::getSlugById(48, Yii::$app->language) . '/';

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        $vars = ['models', 'pages', 'productUrl'];
        return $this->render('index/index', compact($vars));
    }

    /**
     * @param $category string
     * @return string
     */
    public function actionCategory($page)
    {
        Yii::$app->cache->flush();

        $request = Yii::$app->request;
        $pageSize = 2;

        $category = $request->get('cat', false);
        if ($category === false) {
            throw new InvalidParamException("missing parameter «cat»");
        }


        // main query
        $query = Product::find()
            ->innerJoinWith([
                'productI18ns' => function ($query) {
                    $query->where([
                        'i18n_id' => Yii::$app->language,
                    ]);
                }
            ])
            ->where([
                'archived' => 0,
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
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        $vars = ['models', 'pages', 'category'];
        return $this->render($this->renderView, compact($vars));
    }

    /**
     * @param $category string
     * @return string
     */
    public function actionDetails($name)
    {
        $request = Yii::$app->request;
        $pageSize = 2;

        $id = $request->get('prod', false);
        if ($id === false) {
            throw new InvalidParamException("missing parameter «prod»");
        }


        // main query
        $query = Product::find()
            ->where([
                'id' => $id,
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
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        $vars = ['models', 'pages', 'id'];
        return $this->render($this->renderView, compact($vars));
    }
}
