<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\tree;

use Yii;
use kalibao\common\models\attributeType\AttributeType;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\attributeTypeVisibility\AttributeTypeVisibilityI18n;
use kalibao\common\models\attributeType\AttributeTypeI18n;
use kalibao\common\models\branch\BranchI18n;

/**
 * This is the model class for table "attribute_type_visibility".
 *
 * @property integer $attribute_type_id
 * @property integer $branch_id
 *
 * @property AttributeType $attributeType
 * @property Branch $branch
 * @property AttributeTypeVisibilityI18n[] $attributeTypeVisibilityI18ns
 * @property AttributeTypeI18n[] $attributeTypeI18ns
 * @property BranchI18n[] $branchI18ns
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class AttributeTypeVisibility extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_type_visibility';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'attribute_type_id', 'branch_id'
            ],
            'update' => [
                'attribute_type_id', 'branch_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_type_id', 'branch_id'], 'required'],
            [['attribute_type_id', 'branch_id'], 'integer']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeType()
    {
        return $this->hasOne(AttributeType::className(), ['id' => 'attribute_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeTypeVisibilityI18ns()
    {
        return $this->hasMany(AttributeTypeVisibilityI18n::className(), ['attribute_type_id' => 'attribute_type_id', 'branch_id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeTypeI18ns()
    {
        return $this->hasMany(AttributeTypeI18n::className(), ['attribute_type_id' => 'attribute_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchI18ns()
    {
        return $this->hasMany(BranchI18n::className(), ['branch_id' => 'branch_id']);
    }
}
