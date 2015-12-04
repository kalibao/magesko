<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\products\controllers;

use kalibao\common\components\cms\CmsPageService;
use kalibao\common\components\helpers\Arr;
use kalibao\common\models\product\Product;
use kalibao\common\models\sheet\Sheet;
use Yii;
use kalibao\common\models\cmsNews\CmsNews;
use kalibao\common\components\cms\CmsContentBehavior;
use kalibao\frontend\components\web\Controller;
use yii\base\InvalidParamException;
use yii\data\Pagination;
use yii\web\View;

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
        if (Yii::$app->request->get('nocache', false) && YII_ENV_DEV) {
            Yii::$app->cache->flush();
        }

        // page size
        $pageSize = 5;

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
            'defaultPageSize' => $pageSize,
            'params' => $_GET
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
     * @param $page string
     * @return string
     */
    public function actionCategory()
    {
        $request = Yii::$app->request;
        $pageSize = 5;

        $category = $request->get('cat', false);
        if ($category === false) {
            throw new InvalidParamException("missing parameter «cat»");
        }

        $sheets = Sheet::find()
            ->innerJoinWith('sheetType')
            ->where([
                'table' => 'product',
                'branch_id' => $category
                ])
            ->select('sheet.id, sheet_type_id, primary_key')
            ->asArray()
            ->all();

        $productIds = [];
        foreach ($sheets as $sheet) {
            $productIds[] = $sheet['primary_key'];
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
                'product.id' => $productIds
            ]);

        // count query
        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $pageSize,
            'defaultPageSize' => $pageSize,
            'params' => $_GET
        ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        $productUrl = '/' . CmsPageService::getSlugById(48, Yii::$app->language) . '/';

        $vars = ['models', 'pages', 'category', 'productUrl'];
        return $this->render('category/category', compact($vars));
    }

    /**
     * @param $page string
     * @return string
     */
    public function actionCategoryFiltered()
    {
        $request = Yii::$app->request;
        $pageSize = 5;

        $category = $request->post('cat', false);
        $filters  = json_decode($request->post('filters', '{}'), true);
        if ($category === false) {
            throw new InvalidParamException("missing parameter «cat»");
        }

        $sheets = Sheet::find()
            ->innerJoinWith('sheetType')
            ->where([
                'table' => 'product',
                'branch_id' => $category
            ])
            ->select('sheet.id, sheet_type_id, primary_key')
            ->asArray()
            ->all();

        $productIds = [];
        foreach ($sheets as $sheet) {
            $productIds[] = $sheet['primary_key'];
        }

        // main query
        $products = Product::find()
            ->innerJoinWith([
                'productI18ns' => function ($query) {
                    $query->where([
                        'i18n_id' => Yii::$app->language,
                    ]);
                }
            ])
            ->where([
                'archived' => 0,
                'product.id' => $productIds
            ])
            ->all();

        if (Arr::hasValues($filters)) {
            $models = [];
            foreach ($products as $product) { //iterate over products
                $productAttributes = $product->attributeInfo;
                $match = true;
                foreach ($filters as $name => $filter) { //iterate over attribute types
                    $matchType = !Arr::hasValues($filter);
                    foreach ($filter as $value) { //iterate over attribute values
                        if (Arr::has($productAttributes, $name . '.' . explode(':', $value)[1]))
                            $matchType = true;
                    }
                    $match &= $matchType;
                }
                if ($match) $models[] = $product;
            }
        }else {
            $models = $products;
        }


        $pages = new Pagination([
            'totalCount' => sizeof($models),
            'pageSize' => $pageSize,
            'defaultPageSize' => $pageSize,
            'params' => $_GET
        ]);

        $productUrl = '/' . CmsPageService::getSlugById(48, Yii::$app->language) . '/';

        $vars = ['models', 'category', 'productUrl', 'pages'];
        return $this->renderPartial('category/category', compact($vars));
    }

    /**
     * @param $name string
     * @return string
     */
    public function actionDetails()
    {
        $request = Yii::$app->request;

        $id = $request->get('prod', false);
        if ($id === false) {
            throw new InvalidParamException("missing parameter «prod»");
        }

        $model = Product::find()
            ->innerJoinWith([
                'productI18ns' => function ($query) {
                    $query->where([
                        'i18n_id' => Yii::$app->language,
                    ]);
                }
            ])
            ->where([
                'id' => $id
            ])
            ->one();

        $vars = ['model', 'id'];
        return $this->render('details/details', compact($vars));
    }
}
