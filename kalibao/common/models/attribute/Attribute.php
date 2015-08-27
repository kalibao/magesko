<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\attribute;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\attributeType\AttributeType;
use kalibao\common\models\attribute\AttributeI18n;
use kalibao\common\models\variantAttribute\VariantAttribute;
use kalibao\common\models\attributeType\AttributeTypeI18n;

/**
 * This is the model class for table "attribute".
 *
 * @property integer $id
 * @property integer $attribute_type_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AttributeType $attributeType
 * @property AttributeI18n[] $attributeI18ns
 * @property VariantAttribute[] $variantAttributes
 * @property AttributeTypeI18n[] $attributeTypeI18ns
 *
 * @package kalibao\common\models\attribute
 * @version 1.0
 */
class Attribute extends \yii\db\ActiveRecord
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
        return 'attribute';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'attribute_type_id'
            ],
            'update' => [
                'attribute_type_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_type_id'], 'required'],
            [['attribute_type_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','label_attribute_id'),
            'attribute_type_id' => Yii::t('kalibao.backend','label_attribute_type_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
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
    public function getAttributeI18ns()
    {
        return $this->hasMany(AttributeI18n::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getAttributeI18n()
    {
        $i18ns = $this->attributeI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariantAttributes()
    {
        return $this->hasMany(VariantAttribute::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeTypeI18ns()
    {
        return $this->hasMany(AttributeTypeI18n::className(), ['attribute_type_id' => 'attribute_type_id']);
    }
    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getAttributeTypeI18n()
    {
        $i18ns = $this->attributeTypeI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        return false;
    }

}
