<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\mailSendRole;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\mailSendingRole\MailSendingRole;

/**
 * This is the model class for table "mail_send_role".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MailSendRoleI18n[] $mailSendRoleI18ns
 * @property MailSendingRole[] $mailSendingRoles
 *
 * @package kalibao\common\models\mailSendRole
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailSendRole extends \yii\db\ActiveRecord
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
        return 'mail_send_role';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                
            ],
            'update' => [
                
            ],
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
            'id' => Yii::t('kalibao.backend','ID'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendRoleI18ns()
    {
        return $this->hasMany(MailSendRoleI18n::className(), ['mail_send_role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendingRoles()
    {
        return $this->hasMany(MailSendingRole::className(), ['mail_send_role_id' => 'id']);
    }
}
