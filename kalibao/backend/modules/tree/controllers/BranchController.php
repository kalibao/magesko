<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\controllers;

use kalibao\common\models\attributeTypeVisibility\AttributeTypeVisibilityI18n;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\attributeTypeVisibility\AttributeTypeVisibility;
use kalibao\common\models\tree\Tree;
use Yii;
use yii\base\ErrorException;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class BranchController
 *
 * @package kalibao\backend\modules\tree\controllers
 * @version 1.0
 */
class BranchController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\branch\Branch',
        'i18n' => 'kalibao\common\models\branch\BranchI18n',
        'newFilter' => 'kalibao\backend\modules\tree\models\branch\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\tree\components\branch\crud\Edit',
        'list' => 'kalibao\backend\modules\tree\components\branch\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\tree\components\branch\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\tree\components\branch\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\tree\components\branch\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\tree\components\branch\crud\Translate',
        'setting' => 'kalibao\backend\modules\tree\components\branch\crud\Setting',
    ];

    private $dropDownLists = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set upload config
        $this->uploadConfig = [
            $this->crudModelsClass['main'] => [
            ],
        ];

        $this->on(self::EVENT_SAVE_EDIT, function($d){
            if($d->extraData['create']) {
                Yii::$app->getDb()->createCommand('
                    UPDATE `branch`
                    SET `order` = `order`+1
                    WHERE parent = :p AND id <> :id',
                    [
                        'p'  => $d->extraData['models']['main']->parent,
                        'id' => $d->extraData['models']['main']->id
                    ]
                )->execute();
            }
            TagDependency::invalidate(Yii::$app->commonCache, Tree::generateTagStatic($d->extraData['models']['main']->tree_id));
        });

        $this->on(self::EVENT_DELETE, function($d){
            Yii::$app->getDb()->createCommand('
                    UPDATE `branch`
                    SET `order` = `order`-1
                    WHERE parent = :p AND `order` > :o',
                [
                    'p' => $d->extraData['models'][0]->parent,
                    'o' => $d->extraData['models'][0]->order
                ]
            )->execute();
            TagDependency::invalidate(Yii::$app->commonCache, Tree::generateTagStatic($d->extraData['models'][0]->tree_id));
        });
    }

    public function behaviors(){
        $b = parent::behaviors();
        $b['access']['rules'][] = [
            'actions' => ['view', 'advanced-drop-down-list', 'settings', 'export'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
        ];
        $b['access']['rules'][] = [
            'actions' => ['delete-newFilter', 'advanced-drop-down-list', 'settings', 'export'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
        ];
        $b['access']['rules'][] = [
            'actions' => ['add-filter', 'advanced-drop-down-list', 'settings', 'export'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
        ];
        return $b;
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
            throw new HttpException(404, Yii::t('kalibao.backend', 'tree_not_found'));
        }

        $branch = Branch::findOne($request->get('id'));
        $title = ($branch->branchI18ns[0]->label == "")?Yii::t("kalibao.backend", "branch-view"):$branch->branchI18ns[0]->label;

        $vars = ['branch', 'title', 'vars'];

        $create = false;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('view/_contentBlock.php', compact($vars)),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $title
            ];
        } else {
            return $this->render('view/view', compact($vars));
        }
    }

    /**
     * View action
     * @return array|string
     * @throws HttpException
     */
    public function actionDeleteFilter()
    {
        $request = Yii::$app->request;
        if (! $request->isPost) {
            throw new HttpException(405, Yii::t('kalibao.backend', 'not_allowed'));
        }
        $attributeType = $request->post('attribute_type_id');
        $branch        = $request->post('branch_id');
        AttributeTypeVisibility::findOne([
            'attribute_type_id' => $attributeType,
            'branch_id'         => $branch
        ])->delete();
    }

    /**
     * View action
     * @return array|string
     * @throws HttpException
     */
    public function actionAddFilter()
    {
        $request = Yii::$app->request;
        if (! $request->isPost) {
            throw new HttpException(405, Yii::t('kalibao.backend', 'not_allowed'));
        }
        $newFilters = $request->post('insert', []);
        $oldFilters = $request->post('update', []);
        $transaction = Yii::$app->getDb()->beginTransaction();
        $err = false;
        foreach($newFilters as $newFilter) {
            $model = new AttributeTypeVisibility();
            $model->scenario = 'insert';
            $model->attribute_type_id = $newFilter['id'];
            $model->branch_id = $newFilter['branch'];

            $i18n = new AttributeTypeVisibilityI18n();
            $i18n->scenario = 'insert';
            $i18n->attribute_type_id = $newFilter['id'];
            $i18n->branch_id = $newFilter['branch'];
            $i18n->i18n_id = Yii::$app->language;
            $i18n->label = $newFilter['i18n'];

            if (!($model->save() && $i18n->save())) $err = true;
        }
        foreach($oldFilters as $oldFilter) {
            $i18n = AttributeTypeVisibilityI18n::findOne([
                'attribute_type_id' => $oldFilter['id'],
                'branch_id' => $oldFilter['branch'],
                'i18n_id' => Yii::$app->language
            ]);
            $i18n->scenario = 'update';
            $i18n->label = $oldFilter['i18n'];

            if (!$i18n->save()) $err = true;
        }
        if ($err) $transaction->rollBack();
        else $transaction->commit();
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
                case 'google_shopping_category.id':
                    $this->dropDownLists['google_shopping_category.id'] = Html::findDropDownListData(
                        'kalibao\common\models\googleShoppingCategory\GoogleShoppingCategory',
                        ['id', 'id'],
                        []
                    );
                    break;
                case 'affiliation_category.id':
                    $this->dropDownLists['affiliation_category.id'] = Html::findDropDownListData(
                        'kalibao\common\models\affiliationCategory\AffiliationCategory',
                        ['id', 'id'],
                        []
                    );
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
            case 'branch_type_i18n.label':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\branchType\BranchTypeI18n',
                    ['branch_type_id', 'label'],
                    [['LIKE', 'label', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'tree_i18n.label':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\tree\TreeI18n',
                    ['tree_id', 'label'],
                    [['LIKE', 'label', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'branch_i18n.label':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\branch\BranchI18n',
                    ['branch_id', 'label'],
                    [['LIKE', 'label', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'media_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\media\MediaI18n',
                    ['media_id', 'title'],
                    [['LIKE', 'title', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }
}