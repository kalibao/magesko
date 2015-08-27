<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\profile\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use kalibao\backend\components\crud\Controller;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\base\ExtraDataEvent;
use kalibao\common\models\user\User;
use kalibao\common\models\rbacUserRole\RbacUserRole;

/**
 * Class ProfileController
 *
 * @package kalibao\backend\modules\profile\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\person\Person',
        'user' => 'kalibao\common\models\user\User',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\profile\components\profile\crud\Edit',
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

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['get', 'post'],
                    'advanced-drop-down' => ['get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update', 'advanced-drop-down-list',],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('update'), 'permission.update:*'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate()
    {
        // request component
        $request = Yii::$app->request;

        // load models
        $models = $this->loadEditModels(['id' => Yii::$app->user->id]);

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
    protected function saveEditModels(array &$models, array $requestParams)
    {
        /* @var ActiveRecord[] $models */
        $success = false;
        $transaction = $models['main']->getDb()->beginTransaction();
        try {
            // load request
            $models['main']->load($requestParams);
            $models['user']->load($requestParams);
            $models['user']->username = $models['main']->email;
            if ($models['user']->isNewRecord) {
                $models['user']->auth_key = Yii::$app->security->generateRandomString();
            }

            // get uploaded file instance
            $oldFileNames['main'] = [];
            $this->getUploadedFileInstances($models, $oldFileNames, $requestParams);

            // validate model
            $validate['main'] = $models['main']->validate();
            $validate['user'] = $models['user']->validate();

            if (!$validate['main'] || !$validate['user']) {
                // clear password inputs
                $models['user']->password = '';
                $models['user']->password_repeat = '';
                throw new Exception();
            }

            if (!$models['user']->save()) {
                throw new Exception();
            }

            // clear password inputs
            $models['user']->password = '';
            $models['user']->password_repeat = '';

            // set user id
            $models['main']->user_id = $models['user']->id;

            if ($models['main']->save()) {
                // save | remove file
                $this->saveUploadedFileInstances($models, $oldFileNames);
            } else {
                throw new Exception();
            }

            // commit
            $transaction->commit();

            // update scenario
            $models['main']->scenario = 'update';
            $models['user']->scenario = 'update';

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
            'data' => [
                'models' => $models,
                'success' => $success
            ]
        ]));

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

        $models['user'] = new $this->crudModelsClass['user']();
        $models['user']->scenario = 'insert';
        if (! empty($models['main']->user_id)) {
            $tmp = $models['user']->findOne(['id' => $models['main']->user_id]);
            if ($tmp !== null) {
                $models['user'] = $tmp;
                $models['user']->scenario = 'update';
                $models['user']->password = '';
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
                case 'checkbox-drop-down-list':
                    $this->dropDownLists[$id] = Html::checkboxInputFilterDropDownList();
                    break;
                case 'user.status':
                    $statusLabel = User::statusLabels();
                    $this->dropDownLists[$id] = [
                        '' => Yii::t('kalibao', 'input_select'),
                        User::STATUS_ENABLED => $statusLabel[User::STATUS_ENABLED],
                        User::STATUS_DISABLED => $statusLabel[User::STATUS_DISABLED],
                    ];
                    break;
                case 'user.status:required':
                    $statusLabel = User::statusLabels();
                    $this->dropDownLists[$id] = [
                        User::STATUS_ENABLED => $statusLabel[User::STATUS_ENABLED],
                        User::STATUS_DISABLED => $statusLabel[User::STATUS_DISABLED],
                    ];
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
            case 'language_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\language\LanguageI18n',
                    ['language_id', 'title'],
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