<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\product\controllers;

use kalibao\backend\modules\product\components\product\crud\View;
use kalibao\common\components\base\ExtraDataEvent;
use kalibao\common\components\helpers\Database;
use kalibao\common\components\helpers\Date;
use kalibao\common\models\attribute\Attribute;
use kalibao\common\models\attribute\AttributeI18n;
use kalibao\common\models\attributeType\AttributeTypeI18n;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\crossSelling\CrossSelling;
use kalibao\common\models\discount\Discount;
use kalibao\common\models\logisticStrategy\LogisticStrategy;
use kalibao\common\models\product\Product;
use kalibao\common\models\product\ProductI18n;
use kalibao\common\models\productMedia\ProductMedia;
use kalibao\common\models\sheet\Sheet;
use kalibao\common\models\sheetType\SheetType;
use kalibao\common\models\tree\Tree;
use kalibao\common\models\variant\Variant;
use kalibao\common\models\variant\VariantI18n;
use kalibao\common\models\variantAttribute\VariantAttribute;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class ProductController
 *
 * @package kalibao\backend\modules\product\controllers
 * @version 1.0
 */
class ProductController extends Controller
{
    /**
     * @event Event an event that is triggered before the edit model are saved
     */
    const EVENT_BEFORE_SAVE = 'event.save.before';
    
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\product\Product',
        'i18n' => 'kalibao\common\models\product\ProductI18n',
        'variant' => 'kalibao\common\models\variant\Variant',
        'filter' => 'kalibao\backend\modules\product\models\product\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\product\components\product\crud\Edit',
        'list' => 'kalibao\backend\modules\product\components\product\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\product\components\product\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\product\components\product\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\product\components\product\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\product\components\product\crud\Translate',
        'setting' => 'kalibao\backend\modules\product\components\product\crud\Setting',
    ];

    private $dropDownLists = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_BEFORE_SAVE, function($data){
            $data->extraData['models']['main']->available_date = Date::dateToMysql($data->extraData['models']['main']->available_date);
        });
        
        // set upload config
        $this->uploadConfig = [
            $this->crudModelsClass['main'] => [
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $b = parent::behaviors();
        $b['access']['rules'][] = [
                'actions' => ['view', 'advanced-drop-down-list', 'settings', 'export'],
                'allow' => true,
                'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
            ];
        $b['access']['rules'][] = [
            'actions' => [
                'delete-attribute',
                'add-attribute',
                'save-variant',
                'save-variant-price',
                'save-variant-logistic',
                'add-cross-sale',
                'save-discount',
                'update-logistic-strategy',
                'remove-media',
                'update-catalog',
                'generate-combinations',
                'advanced-drop-down-list',
                'settings',
                'export',
            ],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('update'), 'permission.update:*'],
        ];

        return $b;
    }

    /**
     * Load edit models
     * @param array $primaryKey Primary key
     * @return mixed
     * @throws InvalidParamException
     */
    protected function loadEditModels(array $primaryKey = [])
    {
        $models = [];

        $modelClass = $this->crudModelsClass['main'];
        if (!empty($primaryKey)) {
            $models['main'] = $modelClass::findOne($primaryKey);
            if ($models['main'] === null) {
                throw new InvalidParamException('Main model could not be found.');
            } else {
                $models['main']->scenario = 'update';
            }
        } else {
            $models['main'] = new $modelClass(['scenario' => 'insert']);
        }

        $models['i18n'] = new $this->crudModelsClass['i18n']();
        $models['i18n']->scenario = 'beforeInsert';

        if (!empty($primaryKey) && !$models['main']->isNewRecord) {
            $tmp = $models['i18n']::findOne([
                $this->getLinkModelI18n() => $models['main']->{key($primaryKey)},
                'i18n_id' => Yii::$app->language
            ]);

            if ($tmp !== null) {
                $models['i18n'] = $tmp;
                $models['i18n']->scenario = 'update';
                unset($tmp);
            }
        }

        $tmp = $this->crudModelsClass['variant'];
        if (!empty($primaryKey)) {
            $results = $tmp::findAll(['product_id' => $primaryKey['id']]);
            if (is_array($results)) {
                foreach ($results as $result) {
                    $pk = $result->primaryKey;
                    $models['variant'][$pk] = $result;
                    $models['variant'][$pk]->scenario = 'update';
                }
            }
        } else {
            $models['variant'] = new $tmp(['scenario' => 'insert']);
        }

        return $models;
    }

    /**
     * View action
     * @return array|string
     * @throws HttpException
     */
    public function actionView()
    {
        $request = Yii::$app->request;
        if ($request->get('id') === null) {
            throw new HttpException(404, Yii::t('kalibao.backend', 'product_not_found'));
        }
        $catalogTreeId = Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id');
        $tree = Tree::findOne($catalogTreeId);
        $component = new View([
            'models' => $this->loadEditModels(['id' => $request->get('id')]),
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => false,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            },
            'tree' => [
                'title' => $tree->treeI18ns[0]->label,
                'json' => $tree->treeToJson(false),
                'list' => $tree->treeToList()
            ]
        ]);

        $create = false;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('view/_contentBlock.php', compact('component', 'create')),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => !empty($component->models['i18n']->page_title) ? $component->models['i18n']->page_title : $component->models['i18n']->name,
            ];
        } else {
            return $this->render('view/view', compact('component', 'create'));
        }
    }

    /**
     * Update action
     * @return array|string
     */
    public function actionUpdate()
    {
        // request component
        $request = Yii::$app->request;

        $models = $this->loadEditModels(['id' => $request->get('id')]);

        // save models
        $saved = false;
        if ($request->isPost) {;
            $scenario = $request->post('_scenario');
            $saved = $this->saveEditModels($models, $request->post(), $scenario);
            TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id')));
        }

        // create a component to display data
        $catalogTreeId = Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id');
        $tree = Tree::findOne($catalogTreeId);
        $component = new View([
            'models' => $this->loadEditModels(['id' => $request->get('id')]),
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => $saved,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            },
            'tree' => [
                'title' => $tree->treeI18ns[0]->label,
                'json' => $tree->treeToJson(false),
                'list' => $tree->treeToList()
            ]
        ]);

        if ($request->isAjax) {
            return $this->getReturnArray($models, $component, false, $saved);
        } else {
            return $this->render('view/view', ['component' => $component, 'create' => false]);
        }
    }

    /**
     * Create action
     * @return array|string
     * @throws ErrorException
     */
    public function actionCreate()
    {
        // request component
        $request = Yii::$app->request;
        // load models
        $models = $this->loadEditModels();

        // save models
        $saved = false;
        if ($request->isPost) {
            $saved = $this->saveEditModels($models, $request->post());
            if ($saved) return $this->redirect(Url::to(['view'] + ['id' => $models['main']->id]));
        }

        // create a component to display data
        $crudEdit = new View([
            'models' => $models,
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => $saved,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            }
        ]);

        if ($request->isAjax) {
            return $this->getReturnArray($models, $crudEdit, !$saved, $saved);
        } else {
            return $this->render('view/view', ['component' => $crudEdit, 'create' => !$saved]);
        }
    }

    /**
     * Delete attribute action
     * @throws BadRequestHttpException
     */
    public function actionDeleteAttribute()
    {
        $request = Yii::$app->request;
        $params  = $request->post();

        if (isset($params['id'])) {
            $ids = [$params['id']];
        } elseif (isset($params['ids'])) {
            $ids = explode('|', $params['ids']);
        } else {
            throw new BadRequestHttpException('Missing parameter');
        }
        $delete = [];
        $variants = [];
        foreach ($ids as $id) {
            if ($id == '') continue;
            $variants = VariantAttribute::find()->where(['attribute_id' => $id])->joinWith('variant')->all();
            foreach ($variants as $variant) {
                if ($variant->variant->product == $request->get('product'));
                $delete[] = $variant->variant->id;
            }
        }
        Variant::deleteAll(['id'=>$delete]);
        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('product')));

        return $this->getReturnArray($variants, null, false, true);
    }

    /**
     * Add attribute action
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionAddAttribute()
    {
        $transaction = Product::getDb()->beginTransaction();
        $request = Yii::$app->request;
        $product = Product::findOne($request->post('product'));
        if (count(($variants = $product->variantList))) {
            foreach ($variants as $variant)
                $variant->delete();
        }
        $combinations = $this->generate_combinations($request->post('data'));
        try {
            foreach ($combinations as $combination) {
                $discount = new Discount(['scenario' => 'insert']);
                $logistic = new LogisticStrategy(['scenario' => 'insert']);
                $d = $discount->save();
                $l = $logistic->save();
                if ($d && $l) {
                    $variant = new Variant();
                    $variant->scenario = 'insert';
                    $variant->product_id = $request->post('product');
                    $variant->discount_id = $discount->id;
                    $variant->logistic_strategy_id = $logistic->id;
                    if ($variant->save()) {
                        foreach ($combination as $attribute) {
                            $variantAttribute = new VariantAttribute();
                            $variantAttribute->scenario = 'insert';
                            $variantAttribute->attribute_id = $attribute;
                            $variantAttribute->variant_id = $variant->id;
                            if (!$variantAttribute->save()) { // error in variant attribute
                                throw new ErrorException('variantAttribute');
                            }
                        }
                    } else { // error in variant
                        throw new ErrorException('variant');
                    }
                } else { // error in logistic or discount
                    if (!$d) throw new ErrorException('discount');
                    if (!$l) throw new ErrorException('logistic');
                }
            }
            TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id')));
            $transaction->commit();
            return $this->getReturnArray($product, null, false, true);
        } catch (ErrorException $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
            return $this->getReturnArray($product, null, false, false);
        }
    }

    /**
     * Save variant action
     * @return array|string
     * @throws HttpException
     */
    public function actionSaveVariant()
    {
        $request = Yii::$app->request;
        $errors = false;
        $models = [];

        if (!$request->isPost) {
            throw new HttpException(405, 'method not allowed');
        }
        if ($request->get('id') === null) {
            throw new HttpException(404, Yii::t('kalibao.backend', 'product_not_found'));
        }

        $catalogTreeId = Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id');
        $tree = Tree::findOne($catalogTreeId);
        $component = new View([
            'models' => $this->loadEditModels(['id' => $request->get('id')]),
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => false,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            },
            'tree' => [
                'title' => $tree->treeI18ns[0]->label,
                'json' => $tree->treeToJson(false),
                'list' => $tree->treeToList()
            ]
        ]);

        foreach ($request->post('variant', []) as $id => $data) {
            $data['visible'] = (isset($data['visible']) && $data['visible'] == 'on')?1:0;
            $data['top_selling'] = (isset($data['top_selling']) && $data['top_selling'] == 'on')?1:0;
            $data['primary'] = (isset($data['primary']) && $data['primary'] == 'on')?1:0;
            $models['variant'] = Variant::findOne($id);
            $models['variant']->scenario = 'update-variant';
            $models['variant']->attributes = $data;
            if (! $models['variantI18n'] = VariantI18n::findOne(['i18n_id' => Yii::$app->language, 'variant_id' => $models['variant']->id])) {
                $variantI18n = new VariantI18n();
            }
            $models['variantI18n']->scenario = 'insert';
            $models['variantI18n']->i18n_id = Yii::$app->language;
            $models['variantI18n']->variant_id = $models['variant']->id;
            $models['variantI18n']->description = $data['description'];

            if (! $models['variant']->save() || ! $models['variantI18n']->save()) {
                $errors = true;
            }
        }

        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id')));

        return $this->getReturnArray($models, $component, false, !$errors);
    }

//    /**
//     * Save variant price action
//     * @return array|string
//     * @throws HttpException
//     */
//    public function actionSaveVariantPrice()
//    {
//        $request = Yii::$app->request;
//
//        if (!$request->isPost) {
//            throw new HttpException(405, 'method not allowed');
//        }
//        if ($request->get('id') === null) {
//            throw new HttpException(404, Yii::t('kalibao.backend', 'product_not_found'));
//        }
//        foreach ($request->post('attribute', []) as $id => $data) {
//            $variantAttributes = VariantAttribute::findAll(['attribute_id' => $id]);
//            foreach ($variantAttributes as $variantAttribute) {
//                $variantAttribute->scenario = 'update';
//                $variantAttribute->attributes = $data;
//                if (! $variantAttribute->save()) {
//                    Yii::$app->response->format = Response::FORMAT_JSON;
//                    return ['status' => 'error'] + $variantAttribute->getErrors();
//                }
//            }
//        }
//        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id')));
//
//        $catalogTreeId = Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id');
//        $tree = Tree::findOne($catalogTreeId);
//        $component = new View([
//            'models' => $this->loadEditModels(['id' => $request->get('id')]),
//            'language' => Yii::$app->language,
//            'addAgain' => $request->get('add-again', true),
//            'saved' => false,
//            'uploadConfig' => $this->uploadConfig,
//            'dropDownList' => function ($id) {
//                return $this->getDropDownList($id);
//            },
//            'tree' => [
//                'title' => $tree->treeI18ns[0]->label,
//                'json' => $tree->treeToJson(false),
//                'list' => $tree->treeToList()
//            ]
//        ]);
//
//        if ($request->isAjax) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//
//            return [
//                'html' => $this->renderAjax('view/_contentBlock.php', ['component' => $component, 'create' => false]),
//                'scripts' => $this->registerClientSideAjaxScript(),
//                'title' => !empty($component->models['i18n']->page_title) ? $component->models['i18n']->page_title : $component->models['i18n']->name,
//            ];
//        } else {
//            return $this->render('view/view', ['component' => $component, 'create' => false]);
//        }
//    }

    /**
     * Save variant logistic strategy action
     * @return array|string
     * @throws HttpException
     */
    public function actionSaveVariantLogistic()
    {
        $request = Yii::$app->request;

        $catalogTreeId = Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id');
        $tree = Tree::findOne($catalogTreeId);
        $component = new View([
            'models' => $this->loadEditModels(['id' => $request->get('id')]),
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => false,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            },
            'tree' => [
                'title' => $tree->treeI18ns[0]->label,
                'json' => $tree->treeToJson(false),
                'list' => $tree->treeToList()
            ]
        ]);

        if (!$request->isPost) {
            throw new HttpException(405, 'method not allowed');
        }
        if ($request->get('id') === null) {
            throw new HttpException(404, Yii::t('kalibao.backend', 'product_not_found'));
        }
        foreach ($request->post('variant', []) as $id => $data) {
            $variant = Variant::findOne($id);
            $variant->scenario = 'update-logistic';
            $variant->attributes = $data;
            if (! $variant->save()) {
                return $this->getReturnArray($variant, $component, false, false);
            }
        }
        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id'), 'productVariant'));


        if ($request->isAjax) {
            return $this->getReturnArray(null, $component, false);
        } else {
            return $this->render('view/view', ['component' => $component, 'create' => false]);
        }
    }

    /**
     * Add cross sale action
     * @throws \yii\db\Exception
     */
    public function actionAddCrossSale()
    {
        $models = [];
        $errors = false;
        $transaction = Product::getDb()->beginTransaction();
        $request = Yii::$app->request;
        $models['discount'] = new Discount(['scenario' => 'insert']);
        $models['discount']->end_date = (new \DateTime())->format('Y-m-d H:i:s');
        $models['discount']->end_date_vip = (new \DateTime())->format('Y-m-d H:i:s');
        $models['discount']->start_date = (new \DateTime())->format('Y-m-d H:i:s');
        $models['discount']->start_date_vip = (new \DateTime())->format('Y-m-d H:i:s');
        if(!$models['discount']->save()) {
            $errors = true;
        }
        $models['crossSelling'] = new CrossSelling(['scenario' => 'insert']);
        $models['crossSelling']->discount_id  = $models['discount']->id;
        $models['crossSelling']->variant_id_1 = $request->post('variant1');
        $models['crossSelling']->variant_id_2 = $request->post('variant2');
        if(!$models['crossSelling']->save()) {
            $errors = true;
        }
        if ($errors) {
            $transaction->rollBack();
        } else {
            $transaction->commit();
            TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id')));
            TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id')));
        }
        return $this->getReturnArray($models, null, false, !$errors);
    }

    /**
     * Save discount action
     * @return array|string
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function actionSaveDiscount()
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            throw new HttpException(405, 'method not allowed');
        }
        $errors = false;
        $transaction = Discount::getDb()->beginTransaction();
        foreach ($request->post('discount') as $id => $data) {
            $data['start_date'] = Date::dateToMysql($data['start_date']);
            $data['end_date'] = Date::dateToMysql($data['end_date']);
            $data['start_date_vip'] = Date::dateToMysql($data['start_date_vip']);
            $data['end_date_vip'] = Date::dateToMysql($data['end_date_vip']);
            $discount = Discount::findOne($id);
            $discount->scenario = 'update';
            $discount->attributes = $data;
            if (!$discount->save()) {
                $errors = true;
            }
        }
        if ($errors) {
            $transaction->rollBack();
        } else {
            $transaction->commit();
        }
        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id'), 'productVariant'));
        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('id'), 'productCrossSelling'));

        $catalogTreeId = Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id');
        $tree = Tree::findOne($catalogTreeId);
        $component = new View([
            'models' => $this->loadEditModels(['id' => $request->get('id')]),
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => false,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            },
            'tree' => [
                'title' => $tree->treeI18ns[0]->label,
                'json' => $tree->treeToJson(false),
                'list' => $tree->treeToList()
            ]
        ]);

        if ($request->isAjax) {
            return $this->getReturnArray(isset($discount)?$discount:null, $component, false, !$errors);
        } else {
            return $this->render('view/view', ['component' => $component, 'create' => false]);
        }
    }

    /**
     * Update logistic strategy action
     * @throws \yii\db\Exception
     */
    public function actionUpdateLogisticStrategy()
    {
        $request = Yii::$app->request;
        $transaction = LogisticStrategy::getDb()->beginTransaction();
        $logistic = LogisticStrategy::findOne($request->get('id'));
        $logistic->scenario = 'update';
        $logistic->clearData();
        $logistic->strategy = $request->get('strategy');
        $logistic->logisticData = $request->post('strategy');
        if(!$logistic->save()) {
            $transaction->rollBack();
            $errors = true;
        } else {
            $transaction->commit();
            $errors = false;
            TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('product'), 'productLogisticStrategy'));
        }
        return $this->getReturnArray($logistic, null, false, !$errors);
    }

    /**
     * Remove media action
     */
    public function actionRemoveMedia()
    {
        $request = Yii::$app->request;
        $productMedia = ProductMedia::findOne(['product_id' => $request->get('product'), 'media_id' => $request->get('id')]);
        $productMedia->delete();
        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('product')));
    }

    /**
     * Remove media action
     */
    public function actionUpdateCatalog()
    {
        $errors = false;
        $models = [];

        $request = Yii::$app->request;
        $rm = is_array($request->post('rm'))?$request->post('rm'):[];
        $ad = is_array($request->post('ad'))?$request->post('ad'):[];
        $rm = array_map(function($i){return substr($i, 7);}, $rm); // substr : remove "branch-" and keep only the id
        $ad = array_map(function($i){return substr($i, 7);}, $ad); // substr : remove "branch-" and keep only the id

        $sheetType = SheetType::findOne(['table' => 'product']);

        Sheet::deleteAll([
            'sheet_type_id' => $sheetType->id,
            'primary_key'   => $request->post('productId'),
            'branch_id'     => $rm
        ]);
        foreach($ad as $branch) {
            $sheet = new Sheet();
            $sheet->scenario = 'insert';

            $sheet->sheet_type_id = $sheetType->id;
            $sheet->primary_key = $request->post('productId');
            $sheet->branch_id = $branch;

            if(!$sheet->save()) $errors = true;
            $models[] = $sheet;
        }

        $product = Product::findOne($request->post('productId'));
        $product->scenario = 'update';
        $product->attributes = $request->post('Product');
        if($product->validate(['link_brand_product', 'link_product_test'])) {if (!$product->save()) $errors = true;} else $errors = true;
        $models[] = $product;

        TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->post('productId'), 'categories'));
        return $this->getReturnArray($models, null, false, !$errors);
    }

    public function actionGenerateCombinations()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            throw new HttpException(405, 'method not allowed');
        }

        $attributes = [];
        $attributeNames = [];
        $attributeTypeNames = [];
        foreach ($request->post('data') as $data) {
            list($type, $attribute) = explode('-', $data);
            $attributes[$type][] = $attribute;
            $attributeIds[] = $attribute;
            $attributeTypeIds[] = $type;
        }
        $attributeNames = AttributeI18n::find()
            ->where(['i18n_id'=>Yii::$app->language, 'attribute_id' => $attributeIds])
            ->asArray()
            ->all();
        $attributeNames = Database::indexWithPrimaryKey($attributeNames, 'attribute_id');

        $combinations = $this->generate_combinations(array_values($attributes));

        $result = [];
        foreach ($combinations as $combination) {
            $ids = implode('-', $combination);
            $names = [$attributeNames[$combination[0]]['value'], $attributeNames[$combination[1]]['value']];

            $result[$ids] = $names;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * Save edit models
     * @param array $models Models to save
     * @param array $requestParams Request parameters
     * @param string $scenario Scenario for the save action
     * @return bool
     * @throws Exception
     * @throws \yii\base\ErrorException
     * @throws \yii\db\Exception
     */
    protected function saveEditModels(array &$models, array $requestParams, $scenario = 'insert')
    {
        /* @var ActiveRecord[] $models */
        $success = false;
        $transaction = $models['main']->getDb()->beginTransaction();
        try {
            $models['main']->scenario = $scenario;
            $models['i18n']->scenario = $scenario;

            // load request
            $models['main']->load($requestParams);
            $models['i18n']->load($requestParams);
            if (array_key_exists('Variant', $requestParams)) {
                foreach ($models['variant'] as $id => $model) {
                    $model->scenario = $scenario;
                    $model->load(['Variant' => $requestParams['Variant'][$id]]);
                }
            }

            // get uploaded file instance
            $oldFileNames['main'] = [];
            $this->getUploadedFileInstances($models, $oldFileNames, $requestParams);

            // trigger an event
            $this->trigger(self::EVENT_BEFORE_SAVE, new ExtraDataEvent([
                'extraData' => [
                    'models' => $models,
                ]
            ]));
            
            // validate model
            $validate['main'] = $models['main']->validate();
            $validate['i18n'] = true;
            $validate['variant'] = true;
            if ($this->modelExist('i18n')) {
                $validate['i18n'] = $models['i18n']->validate();
            }
            if (array_key_exists('Variant', $requestParams)) {
                foreach ($models['variant'] as $id => $model) {
                    $validate['variant'] &= $model->validate();
                }
            }

            if (! $validate['main'] || ! $validate['i18n'] || ! $validate['variant']) {
                throw new Exception(1);
            }

            if ($models['main']->save()) {
                if ($this->modelExist('i18n')) {
                    $models['i18n']->i18n_id = Yii::$app->language;
                    $models['i18n']->{$this->getLinkModelI18n()} = $models['main']->{$models['main']::primaryKey()[0]};
                    $models['i18n']->scenario = $scenario;
                    if (!$models['i18n']->save()) {
                        throw new Exception(2);
                    }
                }

                if (array_key_exists('Variant', $requestParams)) {
                    foreach ($models['variant'] as $id => $model) {
                        $model->scenario = $scenario;
                        if (!$model->save()) {
                            throw new Exception(2);
                        }
                    }
                }

                // save | remove file
                $this->saveUploadedFileInstances($models, $oldFileNames);
            } else {
                throw new Exception(3);
            }

            // commit
            $transaction->commit();

            // update scenario
            $models['main']->scenario = $scenario;
            if ($this->modelExist('i18n')) {
                $models['i18n']->scenario = 'update';
            }

            $success = true;
        } catch(Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }

            // restore uploaded file instances
            $this->restoreUploadedFileInstances($models);
        }

        // trigger an event
        $this->trigger(self::EVENT_SAVE_EDIT, new ExtraDataEvent([
            'extraData' => [
                'models' => $models,
                'success' => $success
            ]
        ]));

        return $success;
    }

    /**
     * @inheritdoc
     */
    protected function updateUploadedFileName(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function saveUploadedFile(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function removeOldUploadedFile(ActiveRecord $model, $attributeName, $fileName)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function getDropDownList($id)
    {
        if (!isset($this->dropDownLists[$id])) {
            switch ($id) {
                case 'checkbox-drop-down-list':
                    $this->dropDownLists['checkbox-drop-down-list'] = Html::checkboxInputFilterDropDownList();
                    break;
                case 'category_i18n.title':
                    $tree = Tree::findOne(Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id'));
                    $this->dropDownLists['category_i18n.title'] = $tree->treeToList();
                    break;
                default:
                    return [];
                    break;
            }
        }

        return $this->dropDownLists[$id];
    }

    /**
     * @inheritdoc
     */
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {
            case 'product_i18n.name':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\product\ProductI18n',
                    ['product_id', 'name'],
                    [['LIKE', 'name', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'brand.name':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\brand\Brand',
                    ['id', 'name'],
                    [['LIKE', 'name', $search]],
                    10
                );
                break;
            case 'supplier.name':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\supplier\Supplier',
                    ['id', 'name'],
                    [['LIKE', 'name', $search]],
                    10
                );
                break;
            case 'variantList':
                $data = (new ActiveQuery(Variant::className()))
                    ->joinWith('productI18ns')
                    ->where(['LIKE', 'name', $search])
                    ->andWhere(['i18n_id' => Yii::$app->language])
                    ->limit(25)
                    ->all();
                $id = '';
                $value = '';
                $models = [];

                foreach ($data as $variant) {
                    $value = $variant->productI18n->name . ' &nbsp;&bull;&nbsp; ';
                    foreach ($variant->variantAttributes as $varAtt) {
                        $attribute = ($varAtt->attributeI18n)?$varAtt->attributeI18n->value : $varAtt->attributeI18ns[0]->value;
                        $value .= '<span class=badge>' . $attribute . '</span> ';
                    }
                    $models[] = [
                        'id' => $variant->id,
                        'value' => $value
                    ];
                }

                return Html::activeAdvancedDropDownListData($models, 'id', 'value');
                break;

            default:
                return [];
                break;
        }
    }

    /**
     * Generate all the possible combinations among a set of nested arrays.
     *
     * @author fabiocicerchia https://gist.github.com/fabiocicerchia
     *
     * @param array $data  The entry point array container.
     * @param array $all   The final container (used internally).
     * @param array $group The sub container (used internally).
     * @param mixed $value The value to append (used internally).
     * @param int   $i     The key index (used internally).
     *
     * @return array       The combinations
     */
    protected function generate_combinations(array $data, array &$all = array(), array $group = array(), $value = null, $i = 0)
    {
        $keys = array_keys($data);
        if (isset($value) === true) {
            array_push($group, $value);
        }

        if ($i >= count($data)) {
            array_push($all, $group);
        } else {
            $currentKey     = $keys[$i];
            $currentElement = $data[$currentKey];
            foreach ($currentElement as $val) {
                $this->generate_combinations($data, $all, $group, $val, $i + 1);
            }
        }

        return $all;
    }

    protected function getAllErrors($models)
    {
        $errors = [];
        if (!is_array($models)) {
            $errors += $models->getErrors();
        } else {
            foreach ($models as $model) {
                $errors += $this->getAllErrors($model);
            }
        }
        return $errors;
    }

    protected function getReturnArray($models, $component, $create, $saved = true)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($component === null) {
            if ($saved) {
                return [
                    'status'  => 'success',
                ];
            } else {
                return [
                    'status'  => 'error',
                    'errors'  => $this->getAllErrors($models),
                ];
            }
        }
        if ($saved) {
            return [
                'status'  => 'success',
                'html'    => $this->renderAjax('view/_contentBlock.php', ['component' => $component, 'create' => $create]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title'   => !empty($component->models['i18n']->page_title) ? $component->models['i18n']->page_title : $component->models['i18n']->name,
            ];
        } else {
            return [
                'status'  => 'error',
                'errors'  => $this->getAllErrors($models),
                'html'    => $this->renderAjax('view/_contentBlock.php', ['component' => $component, 'create' => $create]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title'   => !empty($component->models['i18n']->page_title) ? $component->models['i18n']->page_title : $component->models['i18n']->name,
            ];
        }
    }
}