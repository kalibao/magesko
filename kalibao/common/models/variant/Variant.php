<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\variant;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\bundle\Bundle;
use kalibao\common\models\crossSelling\CrossSelling;
use kalibao\common\models\product\Product;
use kalibao\common\models\discount\Discount;
use kalibao\common\models\logisticStrategy\LogisticStrategy;
use kalibao\common\models\variantAttribute\VariantAttribute;
use kalibao\common\models\variant\VariantI18n;
use kalibao\common\models\product\ProductI18n;
use kalibao\common\models\logisticStrategy\LogisticStrategyI18n;

/**
 * This is the model class for table "variant".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $code
 * @property string $supplier_code
 * @property string $barcode
 * @property integer $order
 * @property integer $visible
 * @property integer $primary
 * @property integer $top_selling
 * @property float $buy_price
 * @property float $sell_price
 * @property integer $height
 * @property integer $width
 * @property integer $length
 * @property integer $weight
 * @property integer $logistic_strategy_id
 * @property string $last_inventory_date
 * @property string $shipping_period_start
 * @property string $shipping_period_end
 * @property string $selling_period_start
 * @property string $selling_period_end
 * @property integer $discount_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Bundle[] $bundles
 * @property CrossSelling[] $crossSellings
 * @property Product $product
 * @property Discount $discount
 * @property LogisticStrategy $logisticStrategy
 * @property VariantAttribute[] $variantAttributes
 * @property VariantI18n[] $variantI18ns
 * @property ProductI18n[] $productI18ns
 * @property LogisticStrategyI18n[] $logisticStrategyI18ns
 *
 * @package kalibao\common\models\variant
 * @version 1.0
 */
class Variant extends \yii\db\ActiveRecord
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
        return 'variant';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'product_id', 'code', 'supplier_code', 'barcode', 'order', 'visible', 'primary', 'top_selling', 'height', 'width', 'length', 'weight', 'logistic_strategy_id', 'last_inventory_date', 'shipping_period_start', 'shipping_period_end', 'selling_period_start', 'selling_period_end', 'discount_id', 'buy_price', 'sell_price'
            ],
            'update' => [
                'product_id', 'code', 'supplier_code', 'barcode', 'order', 'visible', 'primary', 'top_selling', 'height', 'width', 'length', 'weight', 'logistic_strategy_id', 'last_inventory_date', 'shipping_period_start', 'shipping_period_end', 'selling_period_start', 'selling_period_end', 'discount_id', 'buy_price', 'sell_price'
            ],
            'update-variant' => [
                'code', 'supplier_code', 'barcode', 'order', 'visible', 'primary', 'top_selling'
            ],
            'update-logistic' => [
                'height', 'width', 'length', 'weight', 'logistic_strategy_id'
            ],
            'update_price' => [
                'buy_price', 'sell_price'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'order', 'height', 'width', 'length', 'weight', 'logistic_strategy_id', 'discount_id'], 'integer'],
            [['visible', 'primary', 'top_selling'], 'in', 'range' => [0, 1]],
            [['last_inventory_date', 'shipping_period_start', 'shipping_period_end', 'selling_period_start', 'selling_period_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['code'], 'string', 'max' => 15],
            [['buy_price', 'sell_price'], 'number'],
            [['supplier_code', 'barcode'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','id of the variant'),
            'product_id' => Yii::t('kalibao.backend','product related to the variant'),
            'code' => Yii::t('kalibao.backend','internal reference for the variant'),
            'supplier_code' => Yii::t('kalibao.backend','reference for the variant in the supplier\'s store'),
            'barcode' => Yii::t('kalibao.backend','EAN13 code for the variant'),
            'order' => Yii::t('kalibao.backend','Order'),
            'visible' => Yii::t('kalibao.backend','visibility of the variant in the front website'),
            'primary' => Yii::t('kalibao.backend','1 if the variant is the default variant for the product'),
            'top_selling' => Yii::t('kalibao.backend','1 if the variant is a top selling variant'),
            'height' => Yii::t('kalibao.backend','height of the product (mm)'),
            'width' => Yii::t('kalibao.backend','width of the product (mm)'),
            'length' => Yii::t('kalibao.backend','length of the product (mm)'),
            'weight' => Yii::t('kalibao.backend','weight of the product (g)'),
            'logistic_strategy_id' => Yii::t('kalibao.backend','id of the logistic strategy used for the variant'),
            'last_inventory_date' => Yii::t('kalibao.backend','last time the product was inventored'),
            'shipping_period_start' => Yii::t('kalibao.backend','date from which the product can be sent'),
            'shipping_period_end' => Yii::t('kalibao.backend','date until which the product can be sent'),
            'selling_period_start' => Yii::t('kalibao.backend','date from which the product can be sold'),
            'selling_period_end' => Yii::t('kalibao.backend','date until which the product can be sold'),
            'discount_id' => Yii::t('kalibao.backend','id of the discount applyed to the variant'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBundles()
    {
        return $this->hasMany(Bundle::className(), ['bundle_variant' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrossSellings()
    {
        return $this->hasMany(CrossSelling::className(), ['variant_id_1' => 'id']);
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
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['id' => 'discount_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogisticStrategy()
    {
        return $this->hasOne(LogisticStrategy::className(), ['id' => 'logistic_strategy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariantAttributes()
    {
        return $this->hasMany(VariantAttribute::className(), ['variant_id' => 'id'])->join('inner join', 'attribute', 'attribute_id = attribute.id')->orderBy('attribute_type_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariantI18ns()
    {
        return $this->hasMany(VariantI18n::className(), ['variant_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogisticStrategyI18ns()
    {
        return $this->hasMany(LogisticStrategyI18n::className(), ['logistic_strategy_id' => 'logistic_strategy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getLogisticStrategyI18n()
    {
        $i18ns = $this->logisticStrategyI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }

    public function getFinalPrice()
    {
        $price = (float) $this->product->base_price;
        foreach ($this->variantAttributes as $va) {
            $price += (float) $va->extra_cost;
        }
        return $price;
    }

    public function getBuyPrice() {
        $decimals = (int)Yii::$app->variable->get('kalibao.backend', 'price_decimals_count');
        return number_format(floatval($this->buy_price), $decimals);
    }

    public function getSellPrice() {
        $decimals = (int)Yii::$app->variable->get('kalibao.backend', 'price_decimals_count');
        return number_format(floatval($this->sell_price), $decimals);
    }
}
