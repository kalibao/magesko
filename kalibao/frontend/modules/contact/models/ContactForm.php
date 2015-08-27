<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\contact\models;

use kalibao\common\components\mail\MailTemplate;
use Yii;
use yii\base\Model;

/**
 * Class ContactForm
 * @package kalibao\frontend\modules\contact\models
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $verify_code;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'message'], 'required'],
            [['name', 'phone', 'message'], 'string'],
            ['email', 'email'],
            ['message', 'filter', 'filter' => function($value) {
                return strip_tags($value);
            }],
            ['verify_code', 'captcha', 'captchaAction' => '/contact/contact/captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('kalibao.frontend','contact_form:name'),
            'email' => Yii::t('kalibao.frontend','contact_form:email'),
            'phone' => Yii::t('kalibao.frontend','contact_form:phone'),
            'message' => Yii::t('kalibao.frontend','contact_form:message'),
            'verify_code' => Yii::t('kalibao.frontend','contact_form:verify_code'),
        ];
    }

    /**
     * Send an email
     * @return bool
     */
    public function sendEmail()
    {
        $mailTemplate = new MailTemplate();
        $mailTemplate->staticParams['name'] = $this->name;
        $mailTemplate->staticParams['email'] = $this->email;
        $mailTemplate->staticParams['phone'] = $this->phone;
        $mailTemplate->staticParams['message'] = $this->message;
        return $mailTemplate->sendMailTemplate(3, Yii::$app->language);
    }
}