<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\variantAttribute;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\attribute\Attribute;
use kalibao\common\models\variant\Variant;
use kalibao\common\models\attribute\AttributeI18n;
use kalibao\common\models\variant\VariantI18n;

/**
 * This is the model class for table "variant_attribute".
 *
 * @property integer $variant_id
 * @property integer $attribute_id
 * @property string $extra_cost
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attribute $attribute
 * @property Variant $variant
 * @property AttributeI18n[] $attributeI18ns
 * @property VariantI18n[] $variantI18ns
 *
 * @package kalibao\common\models\variantAttribute
 * @version 1.0
 */
class VariantAttribute extends \yii\db\ActiveRecord
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
        return 'variant_attribute';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'variant_id', 'attribute_id', 'extra_cost'
            ],
            'update' => [
                'variant_id', 'attribute_id', 'extra_cost'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variant_id', 'attribute_id'], 'required'],
            [['variant_id', 'attribute_id'], 'integer'],
            [['extra_cost'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'variant_id' => Yii::t('kalibao.backend','id of the variant'),
            'attribute_id' => Yii::t('kalibao.backend','id of the attribute'),
            'extra_cost' => Yii::t('kalibao.backend','cost added to the base price of the product'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeModel()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariant()
    {
        return $this->hasOne(Variant::className(), ['id' => 'variant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeI18ns()
    {
        return $this->hasMany(AttributeI18n::className(), ['attribute_id' => 'attribute_id']);
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
    public function getVariantI18ns()
    {
        return $this->hasMany(VariantI18n::className(), ['variant_id' => 'variant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getVariantI18n()
    {
        $i18ns = $this->variantI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }
}
