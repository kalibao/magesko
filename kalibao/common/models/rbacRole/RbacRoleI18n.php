<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\rbacRole;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "rbac_role_i18n".
 *
 * @property integer $rbac_role_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property RbacRole $rbacRole
 *
 * @package kalibao\common\models\rbacRole
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class RbacRoleI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rbac_role_i18n';
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
            [['rbac_role_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['rbac_role_id'], 'integer'],
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
            'rbac_role_id' => Yii::t('kalibao.backend','Rbac Role ID'),
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
    public function getRbacRole()
    {
        return $this->hasOne(RbacRole::className(), ['id' => 'rbac_role_id']);
    }
}
