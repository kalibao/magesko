<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\dashboard\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use kalibao\backend\components\web\Controller;
use kalibao\common\components\mail\MailTemplate;
use yii\web\Response;

/**
 * Class DashboardController
 *
 * @package kalibao\backend\modules\dashboard\controllers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class DashboardController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['permission.navigate:backend'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Default action
     */
    public function actionIndex()
    {
        $title = Yii::t('kalibao.backend', 'dashboard_title');

        if (Yii::$app->request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('_contentBlock', ['title' => $title]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $title
            ];
        } else {
            return $this->render('main', ['title' => $title]);
        }
    }
}