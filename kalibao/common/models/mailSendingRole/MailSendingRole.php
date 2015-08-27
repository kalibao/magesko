<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\models\mailSendingRole;

use Yii;
use kalibao\common\models\mailTemplate\MailTemplate;
use kalibao\common\models\mailSendRole\MailSendRole;
use kalibao\common\models\person\Person;
use kalibao\common\models\mailTemplate\MailTemplateI18n;
use kalibao\common\models\mailSendRole\MailSendRoleI18n;

/**
 * This is the model class for table "mail_sending_role".
 *
 * @property integer $person_id
 * @property integer $mail_template_id
 * @property integer $mail_send_role_id
 *
 * @property MailTemplate $mailTemplate
 * @property MailSendRole $mailSendRole
 * @property Person $person
 * @property MailTemplateI18n[] $mailTemplateI18ns
 * @property MailSendRoleI18n[] $mailSendRoleI18ns
 *
 * @package kalibao\common\models\mailSendingRole
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailSendingRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_sending_role';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'person_id', 'mail_template_id', 'mail_send_role_id'
            ],
            'update' => [
                'person_id', 'mail_template_id', 'mail_send_role_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'mail_template_id', 'mail_send_role_id'], 'required'],
            [['person_id', 'mail_template_id', 'mail_send_role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'person_id' => Yii::t('kalibao','person:full_name'),
            'mail_template_id' => Yii::t('kalibao.backend','Mail Template ID'),
            'mail_send_role_id' => Yii::t('kalibao','mail_send_role:id'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplate()
    {
        return $this->hasOne(MailTemplate::className(), ['id' => 'mail_template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendRole()
    {
        return $this->hasOne(MailSendRole::className(), ['id' => 'mail_send_role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplateI18ns()
    {
        return $this->hasMany(MailTemplateI18n::className(), ['mail_template_id' => 'mail_template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendRoleI18ns()
    {
        return $this->hasMany(MailSendRoleI18n::className(), ['mail_send_role_id' => 'mail_send_role_id']);
    }
}
