<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\rbac\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class RbacPermissionController
 *
 * @package kalibao\backend\modules\rbac\controllers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class RbacPermissionController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\rbacPermission\RbacPermission',
        'i18n' => 'kalibao\common\models\rbacPermission\RbacPermissionI18n',
        'filter' => 'kalibao\backend\modules\rbac\models\rbacPermission\crud\ModelFilter'
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\rbac\components\rbacPermission\crud\Edit',
        'list' => 'kalibao\backend\modules\rbac\components\rbacPermission\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\rbac\components\rbacPermission\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\rbac\components\rbacPermission\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\rbac\components\rbacPermission\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\rbac\components\rbacPermission\crud\Translate',
        'setting' => 'kalibao\backend\modules\rbac\components\rbacPermission\crud\Setting',
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

        // refresh users authorisations
        $refreshUsersAuth = function ($event) {
            Yii::$app->user->refreshAllUsersAuth();
        };
        $this->on(self::EVENT_DELETE, $refreshUsersAuth);
        $this->on(self::EVENT_SAVE_EDIT, $refreshUsersAuth);
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
                        'roles' => [
                            $this->getActionControllerPermission('consult'),
                            'permission.consult:*',
                            'permission.administrate:authorizations'
                        ],
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
                        'actions' => ['translate'],
                        'allow' => true,
                        'roles' => [
                            $this->getActionControllerPermission('translate'),
                            'permission.translate:*',
                            'permission.administrate:authorizations'
                        ],
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
            default:
                return [];
                break;
        }
    }
}