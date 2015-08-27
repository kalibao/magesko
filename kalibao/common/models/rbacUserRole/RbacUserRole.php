<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\rbacUserRole;

use Yii;
use kalibao\common\models\rbacRole\RbacRole;
use kalibao\common\models\rbacRole\RbacRoleI18n;
use kalibao\common\models\user\User;

/**
 * This is the model class for table "rbac_user_role".
 *
 * @property integer $user_id
 * @property integer $rbac_role_id
 *
 * @property RbacRole $rbacRole
 * @property User $user
 * @property RbacRoleI18n[] $rbacRoleI18ns
 *
 * @package kalibao\common\models\rbacUserRole
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class RbacUserRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_user_role';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['user_id', 'rbac_role_id'],
            'update' => ['user_id', 'rbac_role_id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rbac_role_id'], 'required'],
            [['user_id', 'rbac_role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('kalibao.backend','User ID'),
            'rbac_role_id' => Yii::t('kalibao.backend','Rbac Role ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacRole()
    {
        return $this->hasOne(RbacRole::className(), ['id' => 'rbac_role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacRoleI18ns()
    {
        return $this->hasMany(RbacRoleI18n::className(), ['rbac_role_id' => 'rbac_role_id']);
    }
}
