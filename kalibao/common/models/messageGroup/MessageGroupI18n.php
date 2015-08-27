<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\messageGroup;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "message_group_i18n".
 *
 * @property integer $message_group_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property MessageGroup $messageGroup
 *
 * @package kalibao\common\models\messageGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MessageGroupI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_group_i18n';
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
            'beforeInsert' => [
                'title'
            ],
            'translate' => [
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
            [['message_group_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['message_group_id'], 'integer'],
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
            'message_group_id' => Yii::t('kalibao.backend','Message Group ID'),
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
    public function getMessageGroup()
    {
        return $this->hasOne(MessageGroup::className(), ['id' => 'message_group_id']);
    }

    /**
     * Get message group indexed by id
     * @param string $language Language ID
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getMessageGroupIndexedById($language)
    {
        return self::find()
            ->select(['message_group_id', 'title'])
            ->where(['i18n_id' => $language])
            ->indexBy('message_group_id')
            ->all();
    }
}
