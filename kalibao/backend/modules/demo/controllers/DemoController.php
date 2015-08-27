<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\demo\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use kalibao\backend\components\web\Controller;
use kalibao\common\components\mail\MailTemplate;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class DemoController
 *
 * @package kalibao\backend\modules\demo\controllers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class DemoController extends Controller
{
    public function actionHelloWorld()
    {
        return $this->render('test');
    }

    /**
     * Send an email
     */
    public function actionSendEmailDemo()
    {
        $mailTemplate = new MailTemplate();
        // reply mail
        $mailTemplate->replyTo = ['email@mail.com', 'Your name'];
        // from mail
        $mailTemplate->sending['from'] = ['email@mail.com', 'Your name'];
        // destination mail
        $mailTemplate->sending['to'] = [['email@mail.com', 'Your name']];
        $mailTemplate->sending['cc'] = [['email@mail.com', 'Your name']];
        $mailTemplate->sending['bcc'] = [['email@mail.com', 'Your name']];
        //$mailTemplate->staticParams['message'] = 'MON MESSAGE';
        //$mailTemplate->sqlParams = ['id' => 1];
        //$mailTemplate->filesPath = ['FILE PATH'];
        $mailTemplate->sendMailTemplate(3, Yii::$app->language);
    }
}