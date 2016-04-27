<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\message\controllers;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use kalibao\common\models\languageGroup\LanguageGroupI18n;
use kalibao\common\models\languageGroupLanguage\LanguageGroupLanguage;
use kalibao\common\models\messageGroup\MessageGroupI18n;

/**
 * Class MessageController
 *
 * @package kalibao\backend\modules\message\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MessageController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\message\Message',
        'i18n' => 'kalibao\common\models\message\MessageI18n',
        'filter' => 'kalibao\backend\modules\message\models\message\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\message\components\message\crud\Edit',
        'list' => 'kalibao\backend\modules\message\components\message\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\message\components\message\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\message\components\message\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\message\components\message\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\message\components\message\crud\Translate',
        'setting' => 'kalibao\backend\modules\message\components\message\crud\Setting',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['get', 'post'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete-rows' => ['post'],
                    'advanced-drop-down' => ['get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'create', 'update', 'delete-rows', 'advanced-drop-down-list', 'settings', ],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('consult'), 'permission.translate:*'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // refresh messages
        $refreshMessages = function () {
            Yii::$app->i18n->getMessageSource('kalibao')->refreshMessages();
        };
        $this->on(self::EVENT_DELETE, $refreshMessages);
        $this->on(self::EVENT_SAVE_EDIT, $refreshMessages);
        $this->on(self::EVENT_SAVE_TRANSLATE, $refreshMessages);
    }

    /**
     * @inheritdoc
     */
    public function actionList()
    {
        // request component
        $request = Yii::$app->request;

        // get groups of languages
        $languagesGroups = (new LanguageGroupI18n())->getGroupLanguageIndexedById(Yii::$app->language);

        // get groups of messages
        $messageGroups = (new MessageGroupI18n())->getMessageGroupIndexedById(Yii::$app->language);

        // default language group ID
        $defaultLanguageGroupId = Yii::$app->variable->get(
            'kalibao', 'language_group_id:'.Yii::$app->appLanguage->languageGroupName
        );

        $languageGroupId = $request->get('language_group_id', null);
        if ($languageGroupId === null || ! isset($languagesGroups[$languageGroupId])) {
            $languageGroupId = $defaultLanguageGroupId;
        }

        // get languages of current language group
        $languageGroupLanguages = (new LanguageGroupLanguage())->getLanguageGroupLanguages($languageGroupId, Yii::$app->language);

        // create a component to display data
        $crudList = new $this->crudComponentsClass['list']([
            'model' => new $this->crudModelsClass['filter'](),
            'crudModelsClass' => $this->crudModelsClass,
            'crudComponentsClass' => $this->crudComponentsClass,
            'requestParams' => $request->get(),
            'language' => Yii::$app->language,
            'languagesGroups' => $languagesGroups,
            'languageGroupLanguages' => $languageGroupLanguages,
            'languageGroupId' => $languageGroupId,
            'messageGroups' => $messageGroups,
            'defaultAction' => Yii::$app->controller->action->getUniqueId(),
            'pageSize' => Yii::$app->interfaceSettings->get(
                Yii::$app->user->id, Yii::$app->id.':'.Yii::$app->controller->getUniqueId()
            )->page_size,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            }
        ]);

        // save models
        $crudList->saved = false;
        if ($request->isPost) {
            $crudList->saved = $this->saveListModels($crudList->getGridRowsEdit(), $request->post());
            // reload grid
            if ($crudList->saved) {
                $crudList->getGridRowsEdit(true);
            }
        }

        if (Yii::$app->request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            foreach (array_keys($this->getView()->assetBundles) as $bundle) {
                $this->getView()->registerAssetFiles($bundle);
            }

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
     * Create action
     * @return array|string
     * @throws ErrorException
     */
    public function actionCreate()
    {
        // request component
        $request = Yii::$app->request;
        // session component
        $session = Yii::$app->session;
        // load models
        $models = $this->loadEditModels();

        // save models
        $saved = false;
        if ($request->isPost) {
            $session->set('backend.messages.lastGroup', $request->post('Message')['message_group_id']);
            $saved = $this->saveEditModels($models, $request->post());
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
            'models' => $models,
            'languageGroupId' => $request->get('language_group_id', null),
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
        $primaryKey = $modelClass::primaryKey()[0];
        if (($value = $request->get($primaryKey, false)) === false || $value === '') {
            throw new InvalidParamException();
        }

        // load models
        $models = $this->loadEditModels([$primaryKey => $value]);

        // save models
        $saved = false;
        if ($request->isPost) {;
            $saved = $this->saveEditModels($models, $request->post());
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
            'models' => $models,
            'languageGroupId' => $request->get('language_group_id', null),
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
    protected function saveListModels(array $crudListEdits, array $requestParams)
    {
        $success = false;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($crudListEdits as $messageId => $crudListEdit) {
                if (isset($requestParams['Message'][$messageId])) {
                    $crudListEdit->models['main']->load($requestParams['Message'][$messageId], '');
                    if (!$crudListEdit->models['main']->save()) {
                        throw new ErrorException();
                    } else {
                        if (isset($requestParams['MessageI18n'][$messageId])) {
                            foreach ($crudListEdit->models['i18n'] as $languageId => $modelI18n) {
                                $modelI18n->load($requestParams['MessageI18n'][$messageId][$languageId], '');
                                if (!$modelI18n->save()) {
                                    throw new ErrorException();
                                }
                            }
                        }
                    }
                }
            }

            // commit
            $transaction->commit();
            $success = true;
        } catch(\Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
        }

        // trigger an event
        $this->trigger(self::EVENT_SAVE_EDIT);

        return $success;
    }

    /**
     * @inheritdoc
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
            $models['main'] = new $modelClass();
            $models['main']->scenario = 'insert';
        }

        // request component
        $request = Yii::$app->request;

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

        foreach ($languageGroupLanguages as $languageGroupLanguage) {
            $models['i18ns'][$languageGroupLanguage->language_id] = new $this->crudModelsClass['i18n']();
            $models['i18ns'][$languageGroupLanguage->language_id]->scenario = 'beforeInsert';

            if (!empty($primaryKey) && !$models['main']->isNewRecord) {
                $tmp = $models['i18ns'][$languageGroupLanguage->language_id]::findOne([
                    $this->getLinkModelI18n() => $models['main']->{key($primaryKey)},
                    'i18n_id' => $languageGroupLanguage->language_id
                ]);

                if ($tmp !== null) {
                    $models['i18ns'][$languageGroupLanguage->language_id] = $tmp;
                    $models['i18ns'][$languageGroupLanguage->language_id]->scenario = 'update';
                    unset($tmp);
                }
            }
        }

        return $models;
    }

    /**
     * @inheritdoc
     */
    protected function saveEditModels(array &$models, array $requestParams)
    {
        /* @var ActiveRecord[] $models */
        $success = false;
        $transaction = $models['main']->getDb()->beginTransaction();
        try {
            // load request
            $models['main']->load($requestParams);

            // validate model
            $validate['main'] = $models['main']->validate();
            $validate['i18n'] = true;

            foreach ($models['i18ns'] as $languageId => $modelI18n) {
                $modelI18n->load($requestParams['MessageI18n'][$languageId], '');
                if (!$modelI18n->validate()) {
                    $validate['i18n'] = false;
                }
            }

            if (! $validate['main'] || ! $validate['i18n']) {
                throw new Exception();
            }

            if ($models['main']->save()) {
                foreach ($models['i18ns'] as $languageId => $modelI18n) {
                    $modelI18n->i18n_id = $languageId;
                    $modelI18n->{$this->getLinkModelI18n()} = $models['main']->{$models['main']::primaryKey()[0]};
                    $modelI18n->scenario = ($modelI18n->scenario === 'beforeInsert') ? 'insert' : 'update';
                    if (!$modelI18n->save()) {
                        throw new Exception();
                    }
                }
            } else {
                throw new Exception();
            }

            // commit
            $transaction->commit();

            // update scenario
            $models['main']->scenario = 'update';
            foreach ($models['i18ns'] as $languageId => $modelI18n) {
                $modelI18n->scenario = 'update';
            }

            $success = true;
        } catch(Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
        }

        // trigger an event
        $this->trigger(self::EVENT_SAVE_EDIT);

        return $success;
    }

    /**
     * @inheritdoc
     */
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {
            case 'message_group_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\messageGroup\MessageGroupI18n',
                    ['message_group_id', 'title'],
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