<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\authentication\controllers;

use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use kalibao\backend\components\web\Controller;
use kalibao\backend\modules\authentication\models\authentication\LoginForm;
use kalibao\common\models\rbacPermission\RbacPermission;
use kalibao\common\models\rbacRole\RbacRole;
use kalibao\common\models\rbacRolePermission\RbacRolePermission;

/**
 * Class AuthenticationController
 *
 * @package kalibao\backend\modules\authentication\controllers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class AuthenticationController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = '/simple/simple';

    /**
     * @inheritdoc
     */
    public $defaultAction = 'login';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
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
                    'login' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * Log in action
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->appLanguage->setLanguage(Yii::$app->user->identity->language);
            return $this->goBack();
        } else {
            return $this->render('/authentication/main', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Log out action
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}