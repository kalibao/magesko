<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\rbacRolePermission;

use Yii;
use kalibao\common\models\rbacRole\RbacRole;
use kalibao\common\models\rbacRole\RbacRoleI18n;
use kalibao\common\models\rbacPermission\RbacPermission;
use kalibao\common\models\rbacPermission\RbacPermissionI18n;

/**
 * This is the model class for table "rbac_role_permission".
 *
 * @property integer $rbac_role_id
 * @property integer $rbac_permission_id
 *
 * @property RbacRole $rbacRole
 * @property RbacPermission $rbacPermission
 * @property RbacRoleI18n[] $rbacRoleI18ns
 * @property RbacPermissionI18n[] $rbacPermissionI18ns
 *
 * @package kalibao\common\models\rbacRolePermission
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class RbacRolePermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_role_permission';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['rbac_role_id', 'rbac_permission_id'],
            'update' => ['rbac_role_id', 'rbac_permission_id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rbac_role_id', 'rbac_permission_id'], 'required'],
            [['rbac_role_id', 'rbac_permission_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rbac_role_id' => Yii::t('kalibao.backend','Rbac Role ID'),
            'rbac_permission_id' => Yii::t('kalibao.backend','Rbac Permission ID'),
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
    public function getRbacPermission()
    {
        return $this->hasOne(RbacPermission::className(), ['id' => 'rbac_permission_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacRoleI18ns()
    {
        return $this->hasMany(RbacRoleI18n::className(), ['rbac_role_id' => 'rbac_role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacPermissionI18ns()
    {
        return $this->hasMany(RbacPermissionI18n::className(), ['rbac_permission_id' => 'rbac_permission_id']);
    }
}
