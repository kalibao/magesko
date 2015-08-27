<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\rbacPermission;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "rbac_permission_i18n".
 *
 * @property integer $rbac_permission_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property RbacPermission $rbacPermission
 * @property Language $i18n
 *
 * @package kalibao\common\models\rbacPermission
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class RbacPermissionI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_permission_i18n';
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
            [['rbac_permission_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['rbac_permission_id'], 'integer'],
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
            'rbac_permission_id' => Yii::t('kalibao.backend','Rbac Permission ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
        ];
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
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
