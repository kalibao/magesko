<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\product;

use Yii;
use kalibao\common\models\product\Product;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "product_i18n".
 *
 * @property integer $product_id
 * @property string $i18n_id
 * @property string $short_description
 * @property string $long_description
 * @property string $comment
 * @property string $page_title
 * @property string $name
 * @property string $infos_shipping
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property Product $product
 * @property Language $i18n
 *
 * @package kalibao\common\models\product
 * @version 1.0
 */
class ProductI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'short_description', 'long_description', 'comment', 'page_title', 'name', 'infos_shipping', 'meta_description', 'meta_keywords'
            ],
            'update' => [
                'short_description', 'long_description', 'comment', 'page_title', 'name', 'infos_shipping', 'meta_description', 'meta_keywords'
            ],
            'translate' => [
                'short_description', 'long_description', 'comment', 'page_title', 'name', 'infos_shipping', 'meta_description', 'meta_keywords'
            ],
            'beforeInsert' => [
                'short_description', 'long_description', 'comment', 'page_title', 'name', 'infos_shipping', 'meta_description', 'meta_keywords'
            ],
            'update_product' => [
                'name'
            ],
            'update_description' => [
                'short_description', 'long_description', 'comment', 'page_title', 'infos_shipping', 'meta_description', 'meta_keywords'
            ],
            'update_price' => [],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['product_id'], 'integer'],
            [['name'], 'required'],
            [['i18n_id'], 'string', 'max' => 10],
            [['short_description', 'meta_description'], 'string', 'max' => 2000],
            [['long_description'], 'string', 'max' => 7000],
            [['comment'], 'string', 'max' => 4000],
            [['page_title'], 'string', 'max' => 750],
            [['name', 'meta_keywords'], 'string', 'max' => 500],
            [['infos_shipping'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id'        => Yii::t('kalibao.backend', 'product_label_product_id'),
            'i18n_id'           => Yii::t('kalibao.backend', 'product_label_i18n_id'),
            'short_description' => Yii::t('kalibao.backend', 'product_label_short_description'),
            'long_description'  => Yii::t('kalibao.backend', 'product_label_long_description'),
            'comment'           => Yii::t('kalibao.backend', 'product_label_comment'),
            'page_title'        => Yii::t('kalibao.backend', 'product_label_page_title'),
            'name'              => Yii::t('kalibao.backend', 'product_label_name'),
            'infos_shipping'    => Yii::t('kalibao.backend', 'product_label_infos_shipping'),
            'meta_description'  => Yii::t('kalibao.backend', 'product_label_meta_description'),
            'meta_keywords'     => Yii::t('kalibao.backend', 'product_label_meta_keywords'),
        ];
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
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
