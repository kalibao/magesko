<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\mailTemplateGroup;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "mail_template_group_i18n".
 *
 * @property integer $mail_template_group_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property MailTemplateGroup $mailTemplateGroup
 *
 * @package kalibao\common\models\mailTemplateGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailTemplateGroupI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_template_group_i18n';
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
            [['mail_template_group_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['mail_template_group_id'], 'integer'],
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
            'mail_template_group_id' => Yii::t('kalibao.backend','Mail Template Group ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
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
    public function getMailTemplateGroup()
    {
        return $this->hasOne(MailTemplateGroup::className(), ['id' => 'mail_template_group_id']);
    }
}
