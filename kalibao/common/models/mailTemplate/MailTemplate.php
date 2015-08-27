<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\mailTemplate;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\mailSendingRole\MailSendingRole;
use kalibao\common\models\mailTemplateGroup\MailTemplateGroup;
use kalibao\common\models\mailTemplateGroup\MailTemplateGroupI18n;

/**
 * This is the model class for table "mail_template".
 *
 * @property integer $id
 * @property integer $mail_template_group_id
 * @property integer $html_mode
 * @property string $sql_request
 * @property string $sql_param
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MailSendingRole[] $mailSendingRoles
 * @property MailTemplateGroup $mailTemplateGroup
 * @property MailTemplateI18n[] $mailTemplateI18ns
 * @property MailTemplateGroupI18n[] $mailTemplateGroupI18ns
 *
 * @package kalibao\common\models\mailTemplate
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function ($event) {
                    return date('Y-m-d h:i:s');
                },
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_template';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'mail_template_group_id', 'html_mode', 'sql_request', 'sql_param'
            ],
            'update' => [
                'mail_template_group_id', 'html_mode', 'sql_request', 'sql_param'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mail_template_group_id', 'html_mode'], 'required'],
            [['mail_template_group_id'], 'integer'],
            [['html_mode'], 'in', 'range' => [0, 1]],
            [['sql_request', 'sql_param'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'mail_template_group_id' => Yii::t('kalibao', 'mail_template:mail_template_group_id'),
            'html_mode' => Yii::t('kalibao', 'mail_template:html_mode'),
            'sql_request' => Yii::t('kalibao', 'mail_template:sql_request'),
            'sql_param' => Yii::t('kalibao', 'mail_template:sql_param'),
            'created_at' => Yii::t('kalibao', 'model:created_at'),
            'updated_at' => Yii::t('kalibao', 'model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendingRoles()
    {
        return $this->hasMany(MailSendingRole::className(), ['mail_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplateGroup()
    {
        return $this->hasOne(MailTemplateGroup::className(), ['id' => 'mail_template_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplateI18ns()
    {
        return $this->hasMany(MailTemplateI18n::className(), ['mail_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplateGroupI18ns()
    {
        return $this->hasMany(MailTemplateGroupI18n::className(), ['mail_template_group_id' => 'mail_template_group_id']);
    }
}
