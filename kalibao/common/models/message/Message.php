<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\message;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\messageGroup\MessageGroup;
use kalibao\common\models\messageGroup\MessageGroupI18n;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $message_group_id
 * @property string $source
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MessageGroup $messageGroup
 * @property MessageI18n[] $messageI18ns
 * @property MessageGroupI18n[] $messageGroupI18ns
 *
 * @package kalibao\common\models\message
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Message extends \yii\db\ActiveRecord
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
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['message_group_id', 'source'],
            'update' => ['message_group_id', 'source'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_group_id', 'source'], 'required'],
            [['message_group_id'], 'integer'],
            [['source'], 'string', 'max' => 255],
            [['source'], 'trim'],
            [['message_group_id'], 'unique', 'targetAttribute' => ['message_group_id', 'source'], 'message' => Yii::t('kalibao', 'The combination of Message Group ID and Source has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'message_group_id' => Yii::t('kalibao','message:message_group_id'),
            'source' => Yii::t('kalibao','message:source'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageGroup()
    {
        return $this->hasOne(MessageGroup::className(), ['id' => 'message_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageI18ns()
    {
        return $this->hasMany(MessageI18n::className(), ['message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageGroupI18ns()
    {
        return $this->hasMany(MessageGroupI18n::className(), ['message_group_id' => 'message_group_id']);
    }
}
