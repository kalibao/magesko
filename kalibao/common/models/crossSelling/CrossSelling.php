<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\crossSelling;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\discount\Discount;
use kalibao\common\models\variant\Variant;
use kalibao\common\models\variant\VariantI18n;

/**
 * This is the model class for table "cross_selling".
 *
 * @property integer $variant_id_1
 * @property integer $variant_id_2
 * @property integer $discount_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Discount $discount
 * @property Variant $variantId1
 * @property Variant $variantId2
 * @property VariantI18n[] $variantI18ns
 *
 * @package kalibao\common\models\crossSelling
 * @version 1.0
 */
class CrossSelling extends \yii\db\ActiveRecord
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
        return 'cross_selling';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'variant_id_1', 'variant_id_2', 'discount_id'
            ],
            'update' => [
                'variant_id_1', 'variant_id_2', 'discount_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variant_id_1', 'variant_id_2', 'discount_id'], 'required'],
            [['variant_id_1', 'variant_id_2', 'discount_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'variant_id_1' => Yii::t('kalibao.backend','id of the first variant'),
            'variant_id_2' => Yii::t('kalibao.backend','id of the second variant'),
            'discount_id' => Yii::t('kalibao.backend','id discount for the current cross sale'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
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
    public function getVariantId1()
    {
        return $this->hasOne(Variant::className(), ['id' => 'variant_id_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariantId2()
    {
        return $this->hasOne(Variant::className(), ['id' => 'variant_id_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariantI18ns()
    {
        return $this->hasMany(VariantI18n::className(), ['variant_id' => 'variant_id_2']);
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
