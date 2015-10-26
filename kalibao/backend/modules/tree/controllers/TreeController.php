<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\controllers;

use kalibao\backend\modules\tree\components\branch\crud\Edit;
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
 * Class treeController
 *
 * @package kalibao\backend\modules\tree\controllers
 * @version 1.0
 */
class TreeController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\tree\Tree',
        'i18n' => 'kalibao\common\models\tree\TreeI18n',
        'filter' => 'kalibao\backend\modules\tree\models\tree\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\tree\components\tree\crud\Edit',
        'list' => 'kalibao\backend\modules\tree\components\tree\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\tree\components\tree\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\tree\components\tree\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\tree\components\tree\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\tree\components\tree\crud\Translate',
        'setting' => 'kalibao\backend\modules\tree\components\tree\crud\Setting',
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
            'kalibao\common\models\media\Media' => [
                'file' => [
                    'basePath' => Yii::getAlias('@kalibao/data'),
                    'baseUrl' => Yii::$app->cdnManager->getBaseUrl() . '/common/data',
                    'type' => 'file'
                ],
            ]
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
                default:
                    return [];
                    break;
            }
        }

        return $this->dropDownLists[$id];
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

        $tree = Tree::findOne($request->get('id'));
        $json = $tree->treeToJson();
        $title = ($tree->treeI18ns[0]->label == "")?Yii::t("kalibao.backend", "tree-home"):$tree->treeI18ns[0]->label;

        $vars = ['json', 'vars', 'title'];

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
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {
            case 'tree_type_i18n.label':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\treeType\TreeTypeI18n',
                    ['tree_type_id', 'label'],
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