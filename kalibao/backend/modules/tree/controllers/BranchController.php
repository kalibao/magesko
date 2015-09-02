<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\controllers;

use kalibao\common\models\branch\Branch;
use Yii;
use yii\base\ErrorException;
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
        'filter' => 'kalibao\backend\modules\tree\models\branch\crud\ModelFilter',
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
    }

    public function behaviors(){
        $b = parent::behaviors();
        $b['access']['rules'][] = [
            'actions' => ['view', 'advanced-drop-down-list', 'settings', 'export'],
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