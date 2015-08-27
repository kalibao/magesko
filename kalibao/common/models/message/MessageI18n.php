<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\message;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "message_i18n".
 *
 * @property integer $message_id
 * @property string $i18n_id
 * @property string $translation
 *
 * @property Message $message
 * @property Language $i18n
 *
 * @package kalibao\common\models\message
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MessageI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'translation'
            ],
            'update' => [
                'translation'
            ],
            'beforeInsert' => [
                'translation'
            ],
            'translate' => [
                'translation'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['message_id'], 'integer'],
            [['translation'], 'string'],
            [['i18n_id'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => Yii::t('kalibao.backend','Message ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'translation' => Yii::t('kalibao','message_i18n:translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
