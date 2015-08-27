<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\controllers;

use Yii;
use kalibao\common\components\cms\CmsMenuSimpleService;
use kalibao\common\models\cmsSimpleMenu\CmsSimpleMenu;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\web\Response;

/**
 * Class CmsSimpleMenuController
 *
 * @package kalibao\backend\modules\cms\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsSimpleMenuController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\cmsSimpleMenu\CmsSimpleMenu',
        'i18n' => 'kalibao\common\models\cmsSimpleMenu\CmsSimpleMenuI18n',
        'filter' => 'kalibao\backend\modules\cms\models\cmsSimpleMenu\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\cms\components\cmsSimpleMenu\crud\Edit',
        'list' => 'kalibao\backend\modules\cms\components\cmsSimpleMenu\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\cms\components\cmsSimpleMenu\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\cms\components\cmsSimpleMenu\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\cms\components\cmsSimpleMenu\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\cms\components\cmsSimpleMenu\crud\Translate',
        'setting' => 'kalibao\backend\modules\cms\components\cmsSimpleMenu\crud\Setting',
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

        $this->on(self::EVENT_DELETE, function ($event) {
            foreach ($event->extraData['models'] as $model) {
                CmsMenuSimpleService::refreshMenu($model->cms_simple_menu_group_id);
            }
        });

        $this->on(self::EVENT_SAVE_EDIT, function ($event) {
            CmsMenuSimpleService::refreshMenu($event->extraData['models']['main']->cms_simple_menu_group_id);
        });

        $this->on(self::EVENT_SAVE_TRANSLATE, function ($event) {
            $listId = [];
            foreach ($event->extraData['models'] as $model) {
                if (!in_array($model->cms_simple_menu_id, $listId)) {
                    $listId[] = $model->cms_simple_menu_id;
                }
            }

            $cmsSimpleMenus = CmsSimpleMenu::find()->select('cms_simple_menu_group_id')->where(['id' => $listId])->asArray()->all();
            foreach ($cmsSimpleMenus as $cmsSimpleMenu) {
                CmsMenuSimpleService::refreshMenu($cmsSimpleMenu['cms_simple_menu_group_id']);
            }
        });
    }

    /**
     * @inheritdoc
     */
    protected function registerClientSideAjaxScript()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function actionList()
    {
        // request component
        $request = Yii::$app->request;
        // response component;
        $response = Yii::$app->response;

        if (($modelFilter = $request->get('ModelFilter', false) && !isset($modelFilter['cms_simple_menu_group_id']))) {
            // create a component to display data
            $crudList = new $this->crudComponentsClass['list']([
                'model' => new $this->crudModelsClass['filter'](),
                'gridRowComponentClass' => $this->crudComponentsClass['listFields'],
                'translatable' => $this->modelExist('i18n'),
                'requestParams' => $request->get(),
                'language' => Yii::$app->language,
                'defaultAction' => Yii::$app->controller->action->getUniqueId(),
                'pageSize' => -1,
                'uploadConfig' => $this->uploadConfig,
                'dropDownList' => function ($id) {
                    return $this->getDropDownList($id);
                }
            ]);

            if (Yii::$app->request->isAjax) {
                // set response format
                Yii::$app->response->format = Response::FORMAT_JSON;

                return [
                    'html' => $this->renderAjax('crud/list/_contentBlock', ['crudList' => $crudList]),
                    'scripts' => $this->registerClientSideAjaxScript(),
                    'title' => $crudList->title
                ];
            } else {
                return $this->render('crud/list/list', ['crudList' => $crudList]);
            }
        } else {
            throw new InvalidParamException();
        }
    }

    /**
     * @inheritdoc
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
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
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
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/edit/_contentBlock', ['crudEdit' => $crudEdit]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/edit/edit', ['crudEdit' => $crudEdit]);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate()
    {
        // request component
        $request = Yii::$app->request;

        // get primary key used to find model
        $modelClass = $this->crudModelsClass['main'];
        $primaryKey = $modelClass::primaryKey();
        $conditions = [];
        foreach ($primaryKey as $primaryKeyElm) {
            if (($value = $request->get($primaryKeyElm, false)) === false || $value === '') {
                throw new InvalidParamException();
            } else {
                $conditions[$primaryKeyElm] = $value;
            }
        }

        // load models
        $models = $this->loadEditModels($conditions);

        // save models
        $saved = false;
        if ($request->isPost) {;
            $saved = $this->saveEditModels($models, $request->post());
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
            'models' => $models,
            'language' => Yii::$app->language,
            'saved' => $saved,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            }
        ]);

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/edit/_contentBlock', ['crudEdit' => $crudEdit]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/edit/edit', ['crudEdit' => $crudEdit]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function loadEditModels(array $primaryKey = [])
    {
        $models = [];

        // request
        $request = Yii::$app->request;

        $modelClass = $this->crudModelsClass['main'];
        if (!empty($primaryKey)) {
            $models['main'] = $modelClass::findOne($primaryKey);
            if ($models['main'] === null) {
                throw new InvalidParamException('Main model could not be found.');
            } else {
                $models['main']->scenario = 'update';
            }
        } else {
            $models['main'] = new $modelClass();
            $models['main']->scenario = 'insert';
        }

        if ($cmsSimpleMenuGroupId = $request->get('cms_simple_menu_group_id', false)) {
            $models['main']->cms_simple_menu_group_id = $cmsSimpleMenuGroupId;
        }

        if ($this->modelExist('i18n')) {
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
        }

        return $models;
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
     * @inheritdoc
     */
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {
            case 'cms_simple_menu_group_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\cmsSimpleMenuGroup\CmsSimpleMenuGroupI18n',
                    ['cms_simple_menu_group_id', 'title'],
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