<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\messageGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\message\Message;

/**
 * This is the model class for table "message_group".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Message[] $messages
 * @property MessageGroupI18n[] $messageGroupI18ns
 *
 * @package kalibao\common\models\messageGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MessageGroup extends \yii\db\ActiveRecord
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
        return 'message_group';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [],
            'update' => [],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['message_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageGroupI18ns()
    {
        return $this->hasMany(MessageGroupI18n::className(), ['message_group_id' => 'id']);
    }
}
