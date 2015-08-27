<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cache\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use kalibao\backend\components\web\Controller;
use kalibao\common\components\mail\MailTemplate;
use yii\web\Response;

/**
 * Class CacheDbController
 *
 * @package kalibao\backend\modules\demo\controllers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class CacheDbController extends Controller
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
                    'refresh' => ['get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['refresh'],
                        'allow' => true,
                        'roles' => ['permission.update:*', $this->getActionControllerPermission('update')],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Refresh db schema
     * @return string
     */
    public function actionRefresh()
    {
        // refresh db schema
        Yii::$app->db->schema->refresh();

        $title = Yii::t('kalibao.backend', 'db_schema_refresh_title');

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