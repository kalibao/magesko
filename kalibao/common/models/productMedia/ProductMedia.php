<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\productMedia;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\media\Media;
use kalibao\common\models\product\Product;
use kalibao\common\models\media\MediaI18n;
use kalibao\common\models\product\ProductI18n;

/**
 * This is the model class for table "product_media".
 *
 * @property integer $product_id
 * @property integer $media_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Media $media
 * @property Product $product
 * @property MediaI18n[] $mediaI18ns
 * @property ProductI18n[] $productI18ns
 *
 * @package kalibao\common\models\productMedia
 * @version 1.0
 */
class ProductMedia extends \yii\db\ActiveRecord
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
        return 'product_media';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'product_id', 'media_id'
            ],
            'update' => [
                'product_id', 'media_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'media_id'], 'required'],
            [['product_id', 'media_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('kalibao.backend','id of the product'),
            'media_id' => Yii::t('kalibao.backend','id of the media'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
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
    public function getMediaI18ns()
    {
        return $this->hasMany(MediaI18n::className(), ['media_id' => 'media_id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getMediaI18n()
    {
        $i18ns = $this->mediaI18ns;
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
