<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\contact\controllers;

use Yii;
use kalibao\common\components\cms\CmsContentBehavior;
use kalibao\frontend\components\web\Controller;
use kalibao\frontend\modules\contact\models\ContactForm;

/**
 * Class ContactController
 *
 * @package kalibao\frontend\modules\contact\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ContactController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            CmsContentBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'minLength' => 3,
                'maxLength' => 3
            ],
        ];
    }

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        $success = false;
        $hasError = false;

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->sendEmail()) {
                    $model = new ContactForm();
                    $success = true;
                } else {
                    $hasError = true;
                }
            } else {
                $hasError = true;
            }
        }

        return $this->render($this->renderView, ['model' => $model, 'success' => $success, 'hasError' => $hasError]);
    }
}
