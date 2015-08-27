<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\rbacPermission;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rbac_permission".
 *
 * @property integer $id
 * @property string $name
 * @property string $rule_path
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RbacPermissionI18n[] $rbacPermissionI18ns
 * @property RbacRolePermission[] $rbacRolePermissions
 *
 * @package kalibao\common\models\rbacPermission
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class RbacPermission extends \yii\db\ActiveRecord
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
        return 'rbac_permission';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['name', 'rule_path'],
            'update' => ['name', 'rule_path'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => ['insert', 'update']],
            [['name', 'rule_path'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'name' => Yii::t('kalibao','rbac_permission:name'),
            'rule_path' => Yii::t('kalibao','rbac_permission:rule_path'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacPermissionI18ns()
    {
        return $this->hasMany(RbacPermissionI18n::className(), ['rbac_permission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacRolePermissions()
    {
        return $this->hasMany(RbacRolePermission::className(), ['rbac_permission_id' => 'id']);
    }
}
