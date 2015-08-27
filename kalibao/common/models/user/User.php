<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
namespace kalibao\common\models\user;

use kalibao\common\models\person\Person;
use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\interfaceSetting\InterfaceSetting;
use kalibao\common\models\mailSendingRole\MailSendingRole;
use kalibao\common\models\rbacUserRole\RbacUserRole;
use kalibao\common\models\rbacRole\RbacRole;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_repeat
 * @property string $auth_key
 * @property integer $status
 * @property string $password_reset_token
 * @property integer $active_password_reset
 * @property string $person_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property InterfaceSetting[] $interfaceSettings
 * @property MailSendingRole[] $mailSendingRoles
 * @property RbacUserRole[] $rbacUserRoles
 * @property RbacRole[] $rbacRoles
 *
 * @package kalibao\common\models\rbacUserRole
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class User extends \yii\db\ActiveRecord
{
    const STATUS_ENABLED =  1;
    const STATUS_DISABLED = 0;

    public $password_repeat;

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
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['username', 'active_password_reset', 'password_reset_token', 'password', 'password_repeat', 'status'],
            'update' => ['username', 'active_password_reset', 'password_reset_token', 'password', 'password_repeat', 'status'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'active_password_reset'], 'required'],
            [['password', 'password_repeat'], 'required', 'on' => ['insert']],
            [['status', 'active_password_reset'], 'integer'],
            ['status', 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],
            [['username'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['password_reset_token', 'default', 'value' => ''],
            ['password', 'compare', 'operator' => '===', 'compareAttribute' => 'password_repeat'],
            [['password', 'password_repeat', 'auth_key', 'password_reset_token'], 'string', 'max' => 64],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->password === '') {
                unset($this->password);
            } else {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao', 'model:id'),
            'username' => Yii::t('kalibao', 'Username'),
            'password' => Yii::t('kalibao', 'user:password'),
            'password_repeat' => Yii::t('kalibao', 'user:password_repeat'),
            'auth_key' => Yii::t('kalibao', 'Auth Key'),
            'status' => Yii::t('kalibao', 'user:status'),
            'password_reset_token' => Yii::t('kalibao', 'Password Reset Token'),
            'active_password_reset' => Yii::t('kalibao', 'user:active_password_reset'),
            'created_at' => Yii::t('kalibao', 'Created At'),
            'updated_at' => Yii::t('kalibao', 'Updated At'),
        ];
    }

    /**
     * Get status labels
     * @return array
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_ENABLED => Yii::t('kalibao', 'user.status:enabled'),
            self::STATUS_DISABLED => Yii::t('kalibao', 'user.status:disabled'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterfaceSettings()
    {
        return $this->hasMany(InterfaceSetting::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendingRoles()
    {
        return $this->hasMany(MailSendingRole::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacUserRoles()
    {
        return $this->hasMany(RbacUserRole::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacRoles()
    {
        return $this->hasMany(RbacRole::className(), ['id' => 'rbac_role_id'])->viaTable('rbac_user_role', ['user_id' => 'id']);
    }
}
