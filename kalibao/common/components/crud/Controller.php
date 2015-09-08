<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use kalibao\backend\components\web\LanguageMenuWidget;
use kalibao\common\models\languageGroup\LanguageGroupI18n;
use kalibao\common\models\languageGroupLanguage\LanguageGroupLanguage;
use Yii;
use ReflectionClass;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use kalibao\common\components\base\ExtraDataEvent;
use kalibao\common\components\validators\ClientSideValidator;

/**
 * Class Controller provide a generic crud controller
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Controller extends \kalibao\common\components\web\Controller
{
    /**
     * @event Event an event that is triggered after model(s) are deleted
     */
    const EVENT_DELETE = 'event.delete';

    /**
     * @event Event an event that is triggered after the edit model are saved
     */
    const EVENT_SAVE_EDIT = 'event.save.edit';

    /**
     * @event Event an event that is triggered after the settings are saved
     */
    const EVENT_SAVE_SETTING = 'event.save.setting';

    /**
     * @event Event an event that is triggered after the translate models are saved
     */
    const EVENT_SAVE_TRANSLATE = 'event.save.translate';

    /**
     * @var string Default action
     */
    public $defaultAction = 'list';

    /**
     * @var string[] Models
     */
    protected $crudModelsClass = [
        'main' => null,
        'i18n' => null,
        'filter' => null,
        'setting' => null
    ];

    /**
     * @var string[] Crud components
     */
    protected $crudComponentsClass = [
        'edit' => null,
        'list' => null,
        'listFields' => null,
        'listFieldsEdit' => null,
        'exportCsv' => null,
        'setting' => null,
        'translate' => null,
    ];

    /**
     * @var string Link between models
     */
    protected $linkModelI18n;

    /**
     * @var bool[] List of existing model
     */
    protected $modelExist;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (! isset($this->crudModelsClass['setting']) || $this->crudModelsClass['setting'] === null) {
            $this->crudModelsClass['setting'] = '\kalibao\common\models\interfaceSetting\InterfaceSetting';
        }
        if (! isset($this->crudComponentsClass['setting']) || $this->crudComponentsClass['setting'] === null) {
            $this->crudComponentsClass['setting'] = '\kalibao\common\components\crud\Setting';
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'translate' => ['get', 'post'],
                    'edit-row' => ['get', 'post'],
                    'refresh-row' => ['get'],
                    'export' => ['get'],
                    'delete-rows' => ['post'],
                    'advanced-drop-down' => ['get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'advanced-drop-down-list', 'settings', 'export'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
                    ],
                    [
                        'actions' => ['create', 'advanced-drop-down-list', 'upload'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('create'), 'permission.create:*'],
                    ],
                    [
                        'actions' => ['update', 'edit-row', 'advanced-drop-down-list', 'refresh-row', 'upload'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('update'), 'permission.update:*'],
                    ],
                    [
                        'actions' => ['translate'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('translate'), 'permission.translate:*'],
                    ],
                    [
                        'actions' => ['delete-rows'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('delete'), 'permission.delete:*'],
                    ]
                    // everything else is denied
                ],
            ],
        ];
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
            },
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
     * Update action
     * @return array|string
     * @throws ErrorException
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
            },
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
     * List action
     * @return array|string
     */
    public function actionList()
    {
        // request component
        $request = Yii::$app->request;

        // create a component to display data
        $crudList = new $this->crudComponentsClass['list']([
            'model' => new $this->crudModelsClass['filter'](),
            'gridRowComponentClass' => $this->crudComponentsClass['listFields'],
            'translatable' => $this->modelExist('i18n'),
            'requestParams' => $request->get(),
            'language' => Yii::$app->language,
            'defaultAction' => Yii::$app->controller->action->getUniqueId(),
            'pageSize' => Yii::$app->interfaceSettings->get(
                    Yii::$app->user->id, Yii::$app->id.':'.Yii::$app->controller->getUniqueId()
                )->page_size,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            },
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
    }

    /**
     * Settings action
     * @return array|string
     * @throws ErrorException
     */
    public function actionSettings()
    {
        // request component
        $request = Yii::$app->request;
        // load model
        $model = $this->loadSettingsModel();

        // save model
        $saved = false;
        if ($request->isPost) {
            $saved = $this->saveSettingsModel($model, $request->post());
        }

        // create a component to display data
        $crudSetting = new $this->crudComponentsClass['setting']([
            'model' => $model,
            'saved' => $saved,
            'language' => Yii::$app->language,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            },
        ]);

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/setting/_contentBlock', ['crudSetting' => $crudSetting]),
                'title' => $crudSetting->title,
            ];
        } else {
            return $this->render('crud/setting/setting', ['crudSetting' => $crudSetting]);
        }
    }

    /**
     * Export action
     * @return array|string
     */
    public function actionExport()
    {
        $export = new $this->crudComponentsClass['exportCsv']([
            'model' => new $this->crudModelsClass['filter'](),
            'uploadConfig' => $this->uploadConfig,
            'requestParams' => Yii::$app->request->get(),
            'language' => Yii::$app->language,
        ]);
        $export->download();
    }

    /**
     * Edit row action
     * @return array
     * @throws ErrorException
     */
    public function actionEditRow()
    {
        // request component
        $request = Yii::$app->request;
        // output
        $output = '';
        // validators
        $validators = [];
        // saved status
        $saved = false;

        if ($request->isAjax) {
            /* @var ActiveRecord $modelClass */
            $modelClass = $this->crudModelsClass['main'];

            // get primary key used to find model
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
            if ($request->isPost) {
                $saved = $this->saveEditModels($models, Yii::$app->request->post());
            }

            if ($saved) {
                // refresh data
                $output = $this->actionRefreshRow()['html'];
            } else {
                // create a component to display data
                $crudListFieldsEdit = new $this->crudComponentsClass['listFieldsEdit']([
                    'models' => $models,
                    'language' => Yii::$app->language,
                    'requestParams' => $request->get(),
                    'uploadConfig' => $this->uploadConfig,
                    'dropDownList' => function ($id) {
                        return $this->getDropDownList($id);
                    },
                ]);

                // get validators
                if ($crudListFieldsEdit->hasClientValidationEnabled()) {
                    $validators = ClientSideValidator::getClientValidators(
                        $crudListFieldsEdit->items, $this->getView()
                    );
                }

                // get output
                $output = $this->renderPartial(
                    'crud/list/_gridBodyRowEdit',
                    ['crudListFieldsEdit' => $crudListFieldsEdit]
                );
            }
        }

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'html' => $output,
            'validators' => $validators,
            'saved' => $saved
        ];
    }

    /**
     * Delete rows action
     * @return array|string
     * @throws ErrorException
     */
    public function actionDeleteRows()
    {
        $success = false;
        $models = [];

        if (is_array($rows = Yii::$app->request->post('rows', false)) && ! empty($rows)) {
            /* @var ActiveRecord $modelClass */
            $modelClass = new $this->crudModelsClass['main']();
            $primaryKey = $modelClass::primaryKey();
            try {
                foreach ($rows as $row) {
                    parse_str($row, $pk);
                    $conditions = [];
                    foreach ($primaryKey as $primaryKeyElm) {
                        if (isset($pk[$primaryKeyElm])) {
                            $conditions[$primaryKeyElm] = $pk[$primaryKeyElm];
                        } else {
                            throw new InvalidParamException();
                        }
                    }
                    if (!empty($conditions)) {
                        $models[] = $model = $modelClass::find()->where($conditions)->one();
                        if ($model) {
                            // delete
                            $model->delete();
                            // delete files
                            if (isset($this->uploadConfig[$this->crudModelsClass['main']])) {
                                foreach ($this->uploadConfig[$this->crudModelsClass['main']] as $attributeName => $config) {
                                    $this->removeOldUploadedFile($model, $attributeName, $model->$attributeName);
                                }
                            }
                        }
                        unset($model);
                    } else {
                        throw new InvalidParamException();
                    }
                }

                $success = true;
            } catch(\Exception $e)
            {}
        }

        // trigger an event
        $this->trigger(self::EVENT_DELETE, new ExtraDataEvent([
            'extraData' => [
                'models' => $models,
                'success' => $success
            ]
        ]));

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['success' => $success];
    }

    /**
     * Refresh row
     * @return array
     * @throws ErrorException
     */
    public function actionRefreshRow()
    {
        /* @var ActiveRecord $model */
        $model = $this->crudModelsClass['filter'];
        // primary key
        $primaryKey = $model::primaryKey();
        // request component
        $request = Yii::$app->request;
        // output
        $output = '';

        $conditions = [];
        foreach ($primaryKey as $primaryKeyElm) {
            if (($value = $request->get($primaryKeyElm, false)) === false || $value === '') {
                throw new InvalidParamException();
            } else {
                $conditions[$primaryKeyElm] = $value;
            }
        }

        $models = (new $this->crudModelsClass['filter'])->search(
            [(new ReflectionClass($model))->getShortName() => $conditions],
            Yii::$app->language,
            1
        )->getModels();

        if (!isset($models[0])) {
            throw new ErrorException('Model does not exist.');
        }

        $row = new $this->crudComponentsClass['listFields']([
            'model' => $models[0],
            'requestParams' => $request->get(),
            'uploadConfig' => $this->uploadConfig,
            'translatable' => $this->modelExist('i18n'),
        ]);

        $output = $this->renderPartial('crud/list/_gridBodyRow', ['row' => $row]);

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['html' => $output];
    }

    /**
     * Advanced drop dow action
     * @return array
     */
    public function actionAdvancedDropDownList()
    {
        if (($id = Yii::$app->request->get('id', false)) !== false &&
            ($search = Yii::$app->request->get('search', false)) !== false) {

            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $this->getAdvancedDropDownList($id, $search);
        } else {
            throw new InvalidParamException();
        }
    }

    /**
     * Translate action
     * @throws NotSupportedException
     */
    public function actionTranslate()
    {
        // Test if language model is implemented
        if (!$this->modelExist('i18n')) {
            throw new NotSupportedException('Translate action is not active for this interface');
        }

        // request component
        $request = Yii::$app->request;

        // get primary key used to find model
        $modelClass = $this->crudModelsClass['main'];
        $primaryKey = $modelClass::primaryKey()[0];
        if (($value = $request->get($primaryKey, false)) === false || $value === '') {
            throw new InvalidParamException('Main model could not be found.');
        }

        // get groups of languages
        $languagesGroups = (new LanguageGroupI18n())->getGroupLanguageIndexedById(Yii::$app->language);

        // default language group ID
        $defaultLanguageGroupId = Yii::$app->variable->get(
            'kalibao', 'language_group_id:'.Yii::$app->appLanguage->languageGroupName
        );

        $languageGroupId = $request->get('language_group_id', null);
        if ($languageGroupId === null || ! isset($languagesGroups[$languageGroupId])) {
            $languageGroupId = $defaultLanguageGroupId;
        }

        // get languages of current language group
        $languageGroupLanguages = (new LanguageGroupLanguage())->getLanguageGroupLanguages(
            $languageGroupId, Yii::$app->language
        );

        $languageGroupLanguagesId = [];
        foreach ($languageGroupLanguages as $languageGroupLanguage) {
            $languageGroupLanguagesId[] = $languageGroupLanguage->language_id;
        }

        // get application languages
        $languages = Yii::$app->appLanguage->reorderLanguages(
            $languageGroupLanguagesId, Yii::$app->language
        );

        // load models
        $models = $this->loadTranslateModels($languages, [$primaryKey => $value]);

        // save models
        $saved = false;
        if ($request->isPost) {
            $saved = $this->saveTranslateModels($models, $request->post());
        }

        $crudTranslate = new $this->crudComponentsClass['translate']([
            'modelClass' => $this->crudModelsClass['i18n'],
            'languagesGroups' => $languagesGroups,
            'languageGroupId' => $languageGroupId,
            'requestParams' => $request->get(),
            'models' => $models,
            'saved' => $saved,
            'pk' => [$primaryKey => $value],
            'language' => Yii::$app->language,
            'languages' => $languages,
        ]);

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/translate/_contentBlock', ['crudTranslate' => $crudTranslate]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudTranslate->title,
            ];
        } else {
            return $this->render('crud/translate/translate', ['crudTranslate' => $crudTranslate]);
        }
    }

    /**
     * Get the link between main model and i18n model
     */
    protected function getLinkModelI18n()
    {
        if ($this->linkModelI18n !== null) {
            return $this->linkModelI18n;
        }

        if ($this->crudModelsClass['i18n'] !== null) {
            /* @var ActiveRecord $modelI18n */
            $modelI18n = new $this->crudModelsClass['i18n']();
            $relation = $modelI18n->getRelation(
                lcfirst((new ReflectionClass($this->crudModelsClass['main']))->getShortName())
            );
            foreach (array_values($relation->link) as $value) {
                if ($value !== 'i18n_id') {
                    $this->linkModelI18n = $value;
                    break;
                }
            }
            if ($this->linkModelI18n === null) {
                throw new ErrorException();
            }
        }

        return $this->linkModelI18n;
    }

    /**
     * Save model of settings
     * @param ActiveRecord $model Model to save
     * @param array $requestParams Request parameters
     * @return bool
     */
    protected function saveSettingsModel(ActiveRecord $model, array $requestParams)
    {
        $success = false;

        $transaction = $model->getDb()->beginTransaction();
        try {
            $model->load($requestParams);
            if ($model->save()) {
                $transaction->commit();
                Yii::$app->interfaceSettings->refreshUserInterfaceSettings($model->user_id, $model->interface_id);
                $success = true;
            } else {
                throw new Exception();
            }
        } catch(Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
        }

        // trigger an event
        $this->trigger(self::EVENT_SAVE_SETTING, new ExtraDataEvent([
            'extraData' => [
                'model' => $model,
                'success' => $success
            ]
        ]));

        return $success;
    }

    /**
     * Save edit models
     * @param array $models Models to save
     * @param array $requestParams Request parameters
     * @return bool
     * @throws Exception
     * @throws \yii\base\ErrorException
     * @throws \yii\db\Exception
     */
    protected function saveEditModels(array &$models, array $requestParams)
    {
        /* @var ActiveRecord[] $models */
        $success = false;
        $transaction = $models['main']->getDb()->beginTransaction();
        try {
            // load request
            $models['main']->load($requestParams);
            if ($this->modelExist('i18n')) {
                $models['i18n']->load($requestParams);
            }

            // get uploaded file instance
            $oldFileNames['main'] = [];
            $this->getUploadedFileInstances($models, $oldFileNames, $requestParams);

            // validate model
            $validate['main'] = $models['main']->validate();
            $validate['i18n'] = true;
            if ($this->modelExist('i18n')) {
                $validate['i18n'] = $models['i18n']->validate();
            }

            if (! $validate['main'] || ! $validate['i18n']) {
                throw new Exception();
            }

            if ($models['main']->save()) {
                if ($this->modelExist('i18n')) {
                    $models['i18n']->i18n_id = Yii::$app->language;
                    $models['i18n']->{$this->getLinkModelI18n()} = $models['main']->{$models['main']::primaryKey()[0]};
                    $models['i18n']->scenario = ($models['i18n']->scenario === 'beforeInsert') ? 'insert' : 'update';
                    if (!$models['i18n']->save()) {
                        throw new Exception();
                    }
                }

                // save | remove file
                $this->saveUploadedFileInstances($models, $oldFileNames);
            } else {
                throw new Exception();
            }

            // commit
            $transaction->commit();

            // update scenario
            $models['main']->scenario = 'update';
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
                'models'  => $models,
                'success' => $success,
                'create'  => (Yii::$app->controller->action->id == 'create'),
            ]
        ]));

        return $success;
    }

    /**
     * Restore uploaded file instances
     * @param ActiveRecord[] $models Models
     */
    protected function restoreUploadedFileInstances(array &$models)
    {
        if (isset($this->uploadConfig[$this->crudModelsClass['main']])) {
            foreach ($this->uploadConfig[$this->crudModelsClass['main']] as $attributeName => $config) {
                $models['main']->$attributeName = $models['main']->getOldAttribute($attributeName);
            }
        }
    }

    /**
     * Save uploaded file instances
     * @param ActiveRecord[] $models Models
     * @param array $oldFileNames Old file names
     * @throws NotSupportedException
     */
    protected function saveUploadedFileInstances(array &$models, array &$oldFileNames)
    {
        if (isset($this->uploadConfig[$this->crudModelsClass['main']])) {
            foreach ($this->uploadConfig[$this->crudModelsClass['main']] as $attributeName => $config) {
                $reflectionClass = new ReflectionClass($this->crudModelsClass['main']);
                if ($models['main']->$attributeName instanceof UploadedFile && $models['main']->$attributeName !== null) {
                    // save file
                    $this->saveUploadedFile($models['main'], $attributeName,
                        $models['main']->$attributeName);

                    // remove old file
                    if (isset($oldFileNames['main'][$attributeName])
                        && $oldFileNames['main'][$attributeName] !== null
                    ) {
                        $this->removeOldUploadedFile($models['main'], $attributeName,
                            $oldFileNames['main'][$attributeName]);
                    }
                } elseif (isset($requestParams[$reflectionClass->getShortName()][$attributeName]) &&
                    $requestParams[$reflectionClass->getShortName()][$attributeName] === '-1'
                ) {
                    // remove old file
                    if (isset($oldFileNames['main'][$attributeName])
                        && $oldFileNames['main'][$attributeName] !== null
                    ) {
                        $this->removeOldUploadedFile($models['main'], $attributeName,
                            $oldFileNames['main'][$attributeName]);
                    }
                }
            }
        }
    }

    /**
     * Get uploaded file instances
     * @param ActiveRecord[] $models Models
     * @param array $oldFileNames Old file names
     * @param array $requestParams Request params
     * @throws NotSupportedException
     */
    protected function getUploadedFileInstances(array &$models, array &$oldFileNames, array $requestParams)
    {
        $reflectionClass['main'] = new ReflectionClass($this->crudModelsClass['main']);
        if (isset($this->uploadConfig[$this->crudModelsClass['main']])) {
            foreach ($this->uploadConfig[$this->crudModelsClass['main']] as $attributeName => $config) {
                $tmp = UploadedFile::getInstance($models['main'], $attributeName);
                if ($tmp !== null) {
                    $models['main']->$attributeName = $tmp;
                    $this->updateUploadedFileName($models['main'], $attributeName, $models['main']->$attributeName);
                    $oldFileNames['main'][$attributeName] = $models['main']->getOldAttribute($attributeName);
                }  elseif (isset($requestParams[$reflectionClass['main']->getShortName()][$attributeName])) {
                    if ($requestParams[$reflectionClass['main']->getShortName()][$attributeName] === '-1') {
                        $oldFileNames['main'][$attributeName] = $models['main']->getOldAttribute($attributeName);
                        $models['main']->$attributeName = '';
                    } else {
                        $models['main']->$attributeName = $models['main']->getOldAttribute($attributeName);
                    }
                }
            }
        }
    }

    /**
     *
     * @param string $modelName Model name
     * @return mixed
     */
    protected function modelExist($modelName)
    {
        if (!isset($this->modelExist[$modelName])) {
            $this->modelExist[$modelName] = isset($this->crudModelsClass[$modelName]) &&
                $this->crudModelsClass[$modelName] !== null;
        }
        return $this->modelExist[$modelName];
    }

    /**
     * Load settings model
     * @return ActiveRecord
     */
    protected function loadSettingsModel()
    {
        $interfaceId = Yii::$app->id.':'.Yii::$app->controller->getUniqueId();
        $model = Yii::$app->interfaceSettings->get(Yii::$app->user->id, $interfaceId);
        if ($model->interface_id === null && $model->user_id === null) {
            $model->interface_id = $interfaceId;
            $model->user_id = Yii::$app->user->id;
        }
        return $model;
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
     * Load translate models
     * @param array $languages Languages ID
     * @param array $primaryKey Primary key
     * @return array
     * @throws ErrorException
     */
    protected function loadTranslateModels(array $languages, array $primaryKey)
    {
        /* @var ActiveRecord $model */
        $model = $this->crudModelsClass['main'];
        /* @var ActiveRecord $modelI18n */
        $modelI18n = $this->crudModelsClass['i18n'];
        $linkModelI18n = $this->getLinkModelI18n();

        if ($model::find()->select(key($primaryKey))->where($primaryKey)->one() !== null) {
            $conditions[$linkModelI18n] = reset($primaryKey);
            $conditions['i18n_id'] = $languages;

            $models = [];
            foreach ($modelI18n::findAll($conditions) as $model) {
                $models[$model->i18n_id] = $model;
            }

            foreach ($languages as $language) {
                if (!isset($models[$language])) {
                    $models[$language] = new $this->crudModelsClass['i18n'](['scenario' => 'translate']);
                    $models[$language]->i18n_id = $language;
                    $models[$language]->$linkModelI18n = $conditions[$linkModelI18n];
                } else {
                    $models[$language]->scenario = 'translate';
                }
            }
        } else {
            throw new ErrorException('Main model could not be found.');
        }

        return $models;
    }

    /**
     * Save translate models
     * @param array $models Models to save
     * @param array $requestParams Request parameters
     * @return bool
     * @throws ErrorException
     */
    protected function saveTranslateModels(array &$models, array $requestParams)
    {
        $success = false;

        $transaction = (new $this->crudModelsClass['i18n']())->getDb()->beginTransaction();
        try {
            $hasError = false;
            /* @var ActiveRecord[] $models */
            foreach ($models as $language => $model) {
                if (isset($requestParams[$language])) {
                    $models[$language]->load($requestParams[$language]);
                }
                if (!$models[$language]->validate()) {
                    $hasError = true;
                }
            }

            if (!$hasError) {
                foreach ($models as $language => $model) {
                    /* @var ActiveRecord $model */
                    if ($model->save()) {
                        $success = true;
                    } else {
                        $success = false;
                        break;
                    }
                }
            }

            if ($success) {
                $transaction->commit();
            } else {
                throw new ErrorException();
            }

        } catch(\Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
        }

        // trigger an event
        $this->trigger(self::EVENT_SAVE_TRANSLATE, new ExtraDataEvent([
            'extraData' => [
                'models' => $models,
                'success' => $success
            ]
        ]));

        return $success;
    }
}
