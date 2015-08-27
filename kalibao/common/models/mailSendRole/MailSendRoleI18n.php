<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\mailSendRole;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "mail_send_role_i18n".
 *
 * @property integer $mail_send_role_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property MailSendRole $mailSendRole
 *
 * @package kalibao\common\models\mailSendRole
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailSendRoleI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_send_role_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'title'
            ],
            'update' => [
                'title'
            ],
            'translate' => [
                'title'
            ],
            'beforeInsert' => [
                'title'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mail_send_role_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['mail_send_role_id'], 'integer'],
            [['title'], 'required'],
            [['i18n_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mail_send_role_id' => Yii::t('kalibao.backend','Mail Send Role ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao.backend','Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendRole()
    {
        return $this->hasOne(MailSendRole::className(), ['id' => 'mail_send_role_id']);
    }
}
