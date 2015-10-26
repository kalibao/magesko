<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\attributeTypeVisibility;

use Yii;
use kalibao\common\models\attributeTypeVisibility\AttributeTypeVisibility;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "attribute_type_visibility_i18n".
 *
 * @property integer $attribute_type_id
 * @property integer $branch_id
 * @property string $i18n_id
 * @property string $label
 *
 * @property AttributeTypeVisibility $attributeType
 * @property Language $i18n
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class AttributeTypeVisibilityI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_type_visibility_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'label'
            ],
            'update' => [
                'label'
            ],
            'translate' => [
                'label'
            ],
            'beforeInsert' => [
                'label'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_type_id', 'branch_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['attribute_type_id', 'branch_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 16],
            [['label'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attribute_type_id' => Yii::t('kalibao.backend','Attribute Type ID'),
            'branch_id' => Yii::t('kalibao.backend','Branch ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'label' => Yii::t('kalibao.backend','label of the attribute type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeType()
    {
        return $this->hasOne(AttributeTypeVisibility::className(), ['attribute_type_id' => 'attribute_type_id', 'branch_id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
