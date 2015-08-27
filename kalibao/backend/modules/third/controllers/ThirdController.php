<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\controllers;

use kalibao\common\components\base\ExtraDataEvent;
use kalibao\common\models\company\Company;
use kalibao\common\models\person\Person;
use kalibao\common\models\third\Third;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class ThirdController
 *
 * @package kalibao\backend\modules\third\controllers
 * @version 1.0
 */
class ThirdController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\third\Third',
        'person' => 'kalibao\common\models\person\Person',
        'company' => 'kalibao\common\models\company\Company',
        'address' => 'kalibao\common\models\address\Address',
        'filter' => 'kalibao\backend\modules\third\models\third\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'editPerson' => 'kalibao\backend\modules\third\components\third\crud\EditPerson',
        'editAddress' => 'kalibao\backend\modules\third\components\third\crud\EditAddress',
        'editCompany' => 'kalibao\backend\modules\third\components\third\crud\EditCompany',
        'list' => 'kalibao\backend\modules\third\components\third\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\third\components\third\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\third\components\third\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\third\components\third\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\third\components\third\crud\Translate',
        'setting' => 'kalibao\backend\modules\third\components\third\crud\Setting',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs']['actions'][] = [
            'create-third' => ['post', 'get'],
        ];
        $behaviors['access']['rules'][] = [
            'actions' => ['create-third', 'advanced-drop-down-list', 'settings', 'export', 'edit-row', 'refresh-row', 'upload'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
        ];
        $behaviors['verbs']['actions'][] = [
            'view' => ['post', 'get'],
        ];
        $behaviors['access']['rules'][] = [
            'actions' => ['view', 'advanced-drop-down-list', 'settings', 'export', 'edit-row', 'refresh-row', 'upload'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
        ];
        return $behaviors;
    }

    /**
     * @var array
     */
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
            $this->crudModelsClass['person'] => [
            ],
            $this->crudModelsClass['company'] => [
            ],
            $this->crudModelsClass['address'] => [
            ],
        ];
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
            case 'third_role_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\third\ThirdRoleI18n',
                    ['third_role_id', 'title'],
                    [['LIKE', 'title', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'third.id':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\third\Third',
                    ['id', 'id'],
                    [['LIKE', 'id', $search]],
                    10
                );
                break;
            case 'language_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\language\LanguageI18n',
                    ['language_id', 'title'],
                    [['LIKE', 'title', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'user.username':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\user\User',
                    ['id', 'username'],
                    [['LIKE', 'username', $search]],
                    10
                );
                break;
            case 'person_gender_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\person\PersonGenderI18n',
                    ['gender_id', 'title'],
                    [['LIKE', 'title', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'company_type_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\company\CompanyTypeI18n',
                    ['company_type_id', 'title'],
                    [['LIKE', 'title', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }

    public function actionCreateThird()
    {
        // request component
        $request = Yii::$app->request;
        $interface = $request->get('interface');

        // 404 redirect
        if ($interface === null) throw new HttpException(404, Yii::t('kalibao.backend', 'no_interface_found'));

        // load models
        $isPerson = $interface == Third::PERSON_INTERFACE;
        $isCompany = $interface == Third::COMPANY_INTERFACE;
        $models = $this->loadEditModelsThird();
        if ($isPerson){
            $models['person'] = new $this->crudModelsClass['person'](['scenario' => 'insert']);
            $models['main']->role_id = Third::PERSON_INTERFACE;
        } else if ($isCompany) {
            $models['company'] = new $this->crudModelsClass['company'](['scenario' => 'insert']);
            $models['main']->role_id = Third::COMPANY_INTERFACE;
        } else {
            throw new HttpException(404, Yii::t('kalibao.backend', 'no_interface_found'));
        }

        // save models
        $saved = false;
        if ($request->isPost) {
            if ($isPerson)
                $saved = $this->saveEditModelsPerson($models, $request->post());
            if ($isCompany)
                $saved = $this->saveCreateModelsCompany($models, $request->post());
        }

        // create a component to display data
        if ($isPerson)
            $crudEdit = new $this->crudComponentsClass['editPerson']([
                'models' => $models,
                'language' => Yii::$app->language,
                'addAgain' => $request->get('add-again', true),
                'saved' => $saved,
                'uploadConfig' => $this->uploadConfig,
                'dropDownList' => function ($id) {
                    return $this->getDropDownList($id);
                }
            ]);
        else if ($isCompany)
            $crudEdit = new $this->crudComponentsClass['editCompany']([
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
                'html' => $this->renderAjax('crud/create/_contentBlock', compact('crudEdit')),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/create/create', compact('crudEdit'));
        }
    }

    protected function loadEditModelsThird(array $primaryKey = [])
    {
        $models = [];
        if (empty($primaryKey)) {
            $models['main'] = new $this->crudModelsClass['main'](['scenario' => 'insert']);
        } else {
            $modelMain = $this->crudModelsClass['main'];
            $models['main'] = $modelMain::findOne($primaryKey);
            if ($models['main'] === null) {
                throw new InvalidParamException('Main model could not be found.');
            } else {
                $models['main']->scenario = 'update';
            }
        }
        return $models;
    }

    protected function saveEditModelsPerson(array &$models, array $requestParams)
    {
        /* @var ActiveRecord[] $models */
        $success = false;
        $transaction = $models['main']->getDb()->beginTransaction();
        try {
            // load request
            $models['main']->load($requestParams);
            $models['person']->load($requestParams);

            // get uploaded file instance
            $oldFileNames['main'] = [];
            $oldFileNames['person'] = [];
            $this->getUploadedFileInstances($models, $oldFileNames, $requestParams);

            if ($models['main']->save()) {
                // save | remove file
                $this->saveUploadedFileInstances($models, $oldFileNames);
            } else {
                throw new Exception();
            }

            $models['person']->third_id = $models['main']->id;

            if (!$models['person']->save()) {
                throw new Exception();
            }



            // commit
            $transaction->commit();

            // update scenario
            $models['main']->scenario = 'update';
            $models['person']->scenario = 'update';

            $success = true;
        } catch(Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
            var_dump($e->getMessage());
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

    protected function saveCreateModelsCompany(array &$models, array $requestParams)
    {
        /* @var ActiveRecord[] $models */
        $success = false;
        $transaction = $models['main']->getDb()->beginTransaction();
        try {
            // load request
            $models['main']->load($requestParams);
            $models['company']->load($requestParams);

            // get uploaded file instance
            $oldFileNames['main'] = [];
            $oldFileNames['company'] = [];
            $this->getUploadedFileInstances($models, $oldFileNames, $requestParams);

            if ($models['main']->save()) {
                // save | remove file
                $this->saveUploadedFileInstances($models, $oldFileNames);
            } else {
                throw new Exception();
            }

            $models['company']->third_id = $models['main']->id;

            if (!$models['company']->save()) {
                throw new Exception();
            }



            // commit
            $transaction->commit();

            // update scenario
            $models['main']->scenario = 'update';
            $models['company']->scenario = 'update';

            $success = true;
        } catch(Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
            var_dump($e->getMessage());
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
        $isPerson = false;
        $isCompany = false;
        $models = $this->loadEditModelsThird($conditions);
        $interface = $models['main']->interface;
        if(get_class($interface) === $this->crudModelsClass['person']) {
            $isPerson = true;
            $models['person'] = $models['main']->interface;
            $models['person']->scenario = 'update';
        } else if (get_class($interface) === $this->crudModelsClass['company']) {
            $isCompany = true;
            $models['company'] = $models['main']->interface;
            $models['company']->scenario = 'update';
        } else {
            throw new HttpException(404, Yii::t('kalibao.backend', 'no_interface_found'));
        }

        // save models
        $saved = false;
        if ($request->isPost) {
            if ($isPerson)
                $saved = $this->saveEditModelsPerson($models, $request->post());
            if ($isCompany)
                $saved = $this->saveCreateModelsCompany($models, $request->post());
        }

        // create a component to display data
        if ($isPerson)
            $crudEdit = new $this->crudComponentsClass['editPerson']([
                'models' => $models,
                'language' => Yii::$app->language,
                'saved' => $saved,
                'uploadConfig' => $this->uploadConfig,
                'dropDownList' => function ($id) {
                    return $this->getDropDownList($id);
                }
            ]);
        else if ($isCompany)
            $crudEdit = new $this->crudComponentsClass['editCompany']([
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
                'html' => $this->renderAjax('crud/create/_contentBlock', ['crudEdit' => $crudEdit]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/create/create', ['crudEdit' => $crudEdit]);
        }
    }

    public function actionView()
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
        $isPerson = false;
        $isCompany = false;
        $models = $this->loadEditModelsThird($conditions);
        $interface = $models['main']->interface;
        if(get_class($interface) === $this->crudModelsClass['person']) {
            $isPerson = true;
            $models['person'] = $models['main']->interface;
            $models['person']->scenario = 'update';
        } else if (get_class($interface) === $this->crudModelsClass['company']) {
            $isCompany = true;
            $models['company'] = $models['main']->interface;
            $models['company']->scenario = 'update';
        } else {
            throw new HttpException(404, Yii::t('kalibao.backend', 'no_interface_found'));
        }

        // save models
        $saved = false;
        if ($request->isPost) {
            if ($isPerson)
                $saved = $this->saveEditModelsPerson($models, $request->post());
            if ($isCompany)
                $saved = $this->saveCreateModelsCompany($models, $request->post());
        }

        // create a component to display data
        if ($isPerson)
            $crudEdit = new $this->crudComponentsClass['editPerson']([
                'models' => $models,
                'language' => Yii::$app->language,
                'saved' => $saved,
                'uploadConfig' => $this->uploadConfig,
                'dropDownList' => function ($id) {
                    return $this->getDropDownList($id);
                }
            ]);
        else if ($isCompany)
            $crudEdit = new $this->crudComponentsClass['editCompany']([
                'models' => $models,
                'language' => Yii::$app->language,
                'saved' => $saved,
                'uploadConfig' => $this->uploadConfig,
                'dropDownList' => function ($id) {
                    return $this->getDropDownList($id);
                }
            ]);

        // list the View need
        $listCompact = ['crudEdit', 'isPerson', 'isCompany'];
        $primaryAddress = $models['main']->primaryAddress;
        if ($primaryAddress !== null) {
            $models['address'] = $primaryAddress;
            $crudAddress = new $this->crudComponentsClass['editAddress']([
                'models' => $models,
                'language' => Yii::$app->language,
                'saved' => $saved,
                'uploadConfig' => $this->uploadConfig,
                'dropDownList' => function ($id) {
                    return $this->getDropDownList($id);
                }
            ]);
            $listCompact[] = 'crudAddress';
        }

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('view/_contentBlock', compact($listCompact, 'listCompact')),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('view/create', compact($listCompact, 'listCompact'));
        }
    }
}