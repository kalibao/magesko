<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\mailTemplate;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "mail_template_i18n".
 *
 * @property integer $mail_template_id
 * @property string $i18n_id
 * @property string $object
 * @property string $message
 *
 * @property MailTemplate $mailTemplate
 * @property Language $i18n
 *
 * @package kalibao\common\models\mailTemplate
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailTemplateI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_template_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'object', 'message'
            ],
            'update' => [
                'object', 'message'
            ],
            'translate' => [
                'object', 'message'
            ],
            'beforeInsert' => [
                'object', 'message'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mail_template_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['mail_template_id'], 'integer'],
            [['object', 'message'], 'required'],
            [['message'], 'string'],
            [['i18n_id'], 'string', 'max' => 16],
            [['object'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mail_template_id' => Yii::t('kalibao.backend','Mail Template ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'object' => Yii::t('kalibao', 'mail_template_i18n:object'),
            'message' => Yii::t('kalibao', 'mail_template_i18n:message'),
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
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
