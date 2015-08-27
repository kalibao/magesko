<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\bundle;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\variant\Variant;
use kalibao\common\models\product\Product;
use kalibao\common\models\variant\VariantI18n;
use kalibao\common\models\product\ProductI18n;

/**
 * This is the model class for table "bundle".
 *
 * @property integer $id
 * @property integer $bundle_variant
 * @property integer $product_id
 * @property integer $variant_id
 * @property integer $quantity
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Variant $variant
 * @property Product $product
 * @property Variant $bundleVariant
 * @property VariantI18n[] $variantI18ns
 * @property ProductI18n[] $productI18ns
 *
 * @package kalibao\common\models\bundle
 * @version 1.0
 */
class Bundle extends \yii\db\ActiveRecord
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
        return 'bundle';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'bundle_variant', 'product_id', 'variant_id', 'quantity'
            ],
            'update' => [
                'bundle_variant', 'product_id', 'variant_id', 'quantity'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bundle_variant', 'product_id'], 'required'],
            [['bundle_variant', 'product_id', 'variant_id', 'quantity'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','id of the bundle'),
            'bundle_variant' => Yii::t('kalibao.backend','id of the variant of the bundle'),
            'product_id' => Yii::t('kalibao.backend','id of a product included in the bundle'),
            'variant_id' => Yii::t('kalibao.backend','variant for the product in the bundle : NULL if choice is given to the client -- variant_id if forced'),
            'quantity' => Yii::t('kalibao.backend','quantity of one product in the bundle'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBundleVariant()
    {
        return $this->hasOne(Variant::className(), ['id' => 'bundle_variant']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductI18ns()
    {
        return $this->hasMany(ProductI18n::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getProductI18n()
    {
        $i18ns = $this->productI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }
}
