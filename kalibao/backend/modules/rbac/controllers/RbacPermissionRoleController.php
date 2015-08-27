<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\rbac\controllers;

use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use kalibao\backend\components\web\Controller;
use kalibao\common\models\rbacPermission\RbacPermission;
use kalibao\common\models\rbacRole\RbacRole;
use kalibao\common\models\rbacRolePermission\RbacRolePermission;

/**
 * Class RbacPermissionRoleController
 *
 * @package kalibao\backend\modules\rbac\controllers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class RbacPermissionRoleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'edit' => ['get', 'post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['permission.administrate:authorizations'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionEdit()
    {
        // request component
        $request = Yii::$app->request;

        $params = [
            'models' => $this->loadEditModels(),
            'title' => Yii::t('kalibao.backend', 'right_permission_role_edit_title'),
            'isSaved' => false,
            'hasErrors' => false
        ];

        // save models
        if ($request->isPost) {;
            $params['isSaved'] = $this->saveEditModels($params['models'], $request->post());
        }

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('edit/_contentBlock', $params),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $params['title'],
            ];
        } else {
            return $this->render('edit/edit', $params);
        }
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
        /* @var \yii\db\ActiveRecord[] $models */
        $success = false;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($models['rbacRolesPermissions'] as $rbacRoleId => $data) {
                foreach ($data as $rbacPermissionId => $rbacRolePermission) {
                    // if the input is checked
                    if ($rbacRolePermission->scenario == 'insert' &&
                            isset($requestParams['rbacRolesPermissions'][$rbacRoleId][$rbacPermissionId]) &&
                            $requestParams['rbacRolesPermissions'][$rbacRoleId][$rbacPermissionId] == 1) {
                        $rbacRolePermission->rbac_role_id = $rbacRoleId;
                        $rbacRolePermission->rbac_permission_id = $rbacPermissionId;
                        if (! $rbacRolePermission->save()) {
                            throw new Exception();
                        }
                    } elseif ($rbacRolePermission->scenario == 'update' &&
                            isset($requestParams['rbacRolesPermissions'][$rbacRoleId][$rbacPermissionId]) &&
                            $requestParams['rbacRolesPermissions'][$rbacRoleId][$rbacPermissionId] == 0) {
                        if (!$rbacRolePermission->delete()) {
                            throw new Exception();
                        }
                        $rbacRolePermission->rbac_role_id = null;
                        $rbacRolePermission->rbac_permission_id = null;
                    }
                }
            }

            // commit
            $transaction->commit();

            // refresh users authorisations
            Yii::$app->user->refreshAllUsersAuth();

            $success = true;
        } catch(Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
        }

        return $success;
    }

    /**
     * Load edit models
     * @return array
     */
    protected function loadEditModels()
    {
        $models = [];

        $models['rbacRoles'] = RbacRole::find()
            ->with([
                'rbacRoleI18ns' => function ($query) {
                    $query
                        ->select(['rbac_role_id', 'title'])
                        ->onCondition(['rbac_role_i18n.i18n_id' => Yii::$app->language]);
                }
            ])
            ->all();

        $models['rbacPermissions'] = RbacPermission::find()
            ->with([
                'rbacPermissionI18ns' => function ($query) {
                    $query
                        ->select(['rbac_permission_id', 'title'])
                        ->onCondition(['rbac_permission_i18n.i18n_id' => Yii::$app->language]);
                }
            ])
            ->all();

        $models['rbacRolesPermissions'] = [];
        foreach (
            RbacRolePermission::find()->all()
            as
            $rbacRolePermission
        ) {
            $models
                ['rbacRolesPermissions']
                [$rbacRolePermission->rbac_role_id]
                [$rbacRolePermission->rbac_permission_id] = $rbacRolePermission;
            $models
                ['rbacRolesPermissions']
                [$rbacRolePermission->rbac_role_id]
                [$rbacRolePermission->rbac_permission_id]->scenario = 'update';
        }

        foreach ($models['rbacRoles'] as $rbacRole) {
            if (isset($rbacRole->rbacRoleI18ns[0])) {
                foreach ($models['rbacPermissions'] as $rbacRolePermission) {
                    if (isset($rbacRolePermission->rbacPermissionI18ns[0]) &&
                        !isset( $models['rbacRolesPermissions'][$rbacRole->id][$rbacRolePermission->id])) {
                        $models
                            ['rbacRolesPermissions']
                            [$rbacRole->id]
                            [$rbacRolePermission->id] = new RbacRolePermission(['scenario' => 'insert']);
                    }
                }
            }
        }

        return $models;
    }
}