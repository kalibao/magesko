<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\rbac\controllers;

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
 * Class PersonUserController
 *
 * @package kalibao\backend\modules\rbac\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class PersonUserController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\person\Person',
        'user' => 'kalibao\common\models\user\User',
        'rbacRoles' => 'kalibao\common\models\rbacRole\RbacRole',
        'rbacUsersRoles' => 'kalibao\common\models\rbacUserRole\RbacUserRole',
        'filter' => 'kalibao\backend\modules\rbac\models\personUser\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\rbac\components\personUser\crud\Edit',
        'list' => 'kalibao\backend\modules\rbac\components\personUser\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\rbac\components\personUser\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\rbac\components\personUser\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\rbac\components\personUser\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\rbac\components\personUser\crud\Translate',
        'setting' => 'kalibao\backend\modules\rbac\components\personUser\crud\Setting',
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
                        'roles' => ['permission.administrate:authorizations'],
                    ],
                    [
                        'actions' => ['update', 'edit-row', 'advanced-drop-down-list', 'refresh-row', 'upload'],
                        'allow' => true,
                        'roles' => ['permission.administrate:authorizations'],
                    ],
                    [
                        'actions' => ['delete-rows'],
                        'allow' => true,
                        'roles' => ['permission.administrate:authorizations'],
                    ]
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionDeleteRows()
    {
        $success = false;
        $allPrimaryKey = [];

        if (is_array($rows = Yii::$app->request->post('rows', false)) && ! empty($rows)) {
            /* @var ActiveRecord $userModel */
            $userModel = new $this->crudModelsClass['user']();
            /* @var ActiveRecord $mainModel */
            $mainModel = new $this->crudModelsClass['main']();
            $primaryKey = $mainModel::primaryKey()[0];
            try {
                foreach ($rows as $row) {
                    parse_str($row, $pk);
                    $conditions = [];
                    if (isset($pk[$primaryKey])) {
                        $conditions[$primaryKey] = $pk[$primaryKey];
                        $allPrimaryKey[] = $conditions[$primaryKey];
                        $person = $mainModel::findOne($conditions);
                        if ($person !== null) {
                            if ($person->user_id != null) {
                                $userModel::deleteAll(['id' => $person->user_id]);
                                Yii::$app->user->refreshUserAuth($person->user_id);
                            }
                            $person->delete();
                        }
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
                'primaryKeys' => $allPrimaryKey,
                'success' => $success
            ]
        ]));

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['success' => $success];
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
            if (isset($requestParams['rbacUserRolesId']) && is_array($requestParams['rbacUserRolesId'])) {
                foreach ($requestParams['rbacUserRolesId'] as $rbacRoleId) {
                    if (isset($models['rbacRoles'][$rbacRoleId]) && !isset($models['rbacUserRoles'][$rbacRoleId])) {
                        $models['rbacUserRoles'][$rbacRoleId] = new RbacUserRole(['scenario' => 'insert']);
                        $models['rbacUserRoles'][$rbacRoleId]->rbac_role_id = $rbacRoleId;
                    }
                }
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

            if (isset($requestParams['rbacUserRolesId'])) {
                // delete user roles
                foreach ($models['rbacUserRoles'] as $rbacRoleId => $rbacUserRole) {
                    if (isset($models['rbacRoles'][$rbacRoleId]) &&
                        (!is_array($requestParams['rbacUserRolesId']) ||
                            !in_array($rbacRoleId, $requestParams['rbacUserRolesId']))) {
                        $rbacUserRole->delete();
                        unset($models['rbacUserRoles'][$rbacRoleId]);
                    }
                }

                // save user roles
                foreach ($models['rbacUserRoles'] as $rbacUserRole) {
                    if ($rbacUserRole->scenario === 'insert') {
                        $rbacUserRole->user_id = $models['user']->id;
                        $rbacUserRole->save();
                    }
                }
            }

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

            if (isset($requestParams['rbacUserRolesId'])) {
                Yii::$app->user->refreshUserAuth($models['main']->user_id);
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

        $rbacRoles = $this->crudModelsClass['rbacRoles'];
        $rbacRolesList = $rbacRoles::find()
            ->select('id')
            ->with([
                'rbacRoleI18ns' => function ($query) {
                    $query
                        ->select(['rbac_role_id', 'title'])
                        ->onCondition(['rbac_role_i18n.i18n_id' => Yii::$app->language]);
                }
            ])
            ->all();

        $models['rbacRoles'] = [];
        foreach ($rbacRolesList as $rbacRole) {
            if (isset($rbacRole->rbacRoleI18ns[0])) {
                $models['rbacRoles'][$rbacRole->id] = $rbacRole;
            }
        }
        unset ($rbacRolesList);

        $rbacUsersRoles = $this->crudModelsClass['rbacUsersRoles'];
        $models['rbacUserRoles'] = [];
        if (!empty($models['user']->id)) {
            $rbacUserRolesList = $rbacUsersRoles::findAll(['user_id' => $models['user']->id]);
            foreach ($rbacUserRolesList as $rbacUserRole) {
                $models['rbacUserRoles'][$rbacUserRole->rbac_role_id] = $rbacUserRole;
            }
            unset ($rbacUserRolesList);
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