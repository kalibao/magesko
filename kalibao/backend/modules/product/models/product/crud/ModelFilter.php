<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\product\models\product\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\product\Product;

/**
 * This is the model filter class for controller "Product".
 *
 * @property integer $id
 * @property integer $exclude_discount_code
 * @property integer $force_secure
 * @property integer $archived
 * @property integer $top_product
 * @property integer $exclude_from_google
 * @property string $link_brand_product
 * @property string $link_product_test
 * @property integer $available
 * @property string $available_date
 * @property string $alternative_product_i18n_name
 * @property integer $alternative_product
 * @property string $brand_name
 * @property integer $brand_id
 * @property string $supplier_name
 * @property integer $supplier_id
 * @property string $catalog_category_i18n_title
 * @property integer $catalog_category_id
 * @property string $google_category_i18n_title
 * @property integer $google_category_id
 * @property string $stats_category_i18n_title
 * @property integer $stats_category_id
 * @property string $accountant_category_i18n_title
 * @property integer $accountant_category_id
 * @property string $base_price
 * @property integer $is_pack
 * @property string $product_i18n_short_description
 * @property string $product_i18n_long_description
 * @property string $product_i18n_comment
 * @property string $product_i18n_page_title
 * @property string $product_i18n_name
 * @property string $product_i18n_infos_shipping
 * @property string $product_i18n_meta_description
 * @property string $product_i18n_meta_keywords
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\product\models\product\crud
 * @version 1.0
 */
class ModelFilter extends Product implements ModelFilterInterface
{
    public $alternative_product_i18n_name;
    public $brand_name;
    public $supplier_name;
    public $stats_category_i18n_title;
    public $google_category_i18n_title;
    public $accountant_category_i18n_title;
    public $product_i18n_short_description;
    public $product_i18n_long_description;
    public $product_i18n_comment;
    public $product_i18n_page_title;
    public $product_i18n_name;
    public $product_i18n_infos_shipping;
    public $product_i18n_meta_description;
    public $product_i18n_meta_keywords;
    public $created_at_start;
    public $created_at_end;
    public $updated_at_start;
    public $updated_at_end;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id', 'exclude_discount_code', 'force_secure', 'archived', 'top_product', 'exclude_from_google', 'link_brand_product', 'link_product_test', 'available', 'available_date', 'product_i18n_name', 'alternative_product', 'brand_name', 'brand_id', 'supplier_name', 'supplier_id', 'catalog_category_i18n_title', 'catalog_category_id', 'stats_category_i18n_title', 'google_category_id', 'google_category_i18n_title', 'stats_category_id', 'accountant_category_i18n_title', 'accountant_category_id', 'base_price', 'is_pack', 'product_i18n_short_description', 'product_i18n_long_description', 'product_i18n_comment', 'product_i18n_page_title', 'product_i18n_name', 'product_i18n_infos_shipping', 'product_i18n_meta_description', 'product_i18n_meta_keywords', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'alternative_product', 'brand_id', 'supplier_id', 'catalog_category_id', 'google_category_id', 'stats_category_id', 'accountant_category_id'], 'integer'],
            [['exclude_discount_code', 'force_secure', 'archived', 'top_product', 'exclude_from_google', 'available', 'is_pack'], 'in', 'range' => [0, 1]],
            [['available_date'], 'safe'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['base_price'], 'number'],
            [['link_brand_product', 'link_product_test', 'brand_name', 'supplier_name'], 'string', 'max' => 255],
            [['product_i18n_name', 'product_i18n_name', 'product_i18n_meta_keywords'], 'string', 'max' => 500],
            [['category_i18n_title', 'category_i18n_title', 'category_i18n_title', 'category_i18n_title'], 'string', 'max' => 200],
            [['product_i18n_short_description', 'product_i18n_meta_description'], 'string', 'max' => 2000],
            [['product_i18n_long_description'], 'string', 'max' => 7000],
            [['product_i18n_comment'], 'string', 'max' => 4000],
            [['product_i18n_page_title'], 'string', 'max' => 750],
            [['product_i18n_infos_shipping'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'alternative_product_i18n_name' =>   Yii::t('kalibao.backend','alternative_product_i18n_name'),
            'brand_name' =>                      Yii::t('kalibao.backend','brand_name'),
            'supplier_name' =>                   Yii::t('kalibao.backend','supplier_name'),
            'catalog_category_i18n_title' =>     Yii::t('kalibao.backend','catalog_category_i18n_title'),
            'stats_category_i18n_title' =>       Yii::t('kalibao.backend','stats_category_i18n_title'),
            'google_category_i18n_title' =>      Yii::t('kalibao.backend','google_category_i18n_title'),
            'accountant_category_i18n_title' =>  Yii::t('kalibao.backend','accountant_category_i18n_title'),
            'product_i18n_short_description' =>  Yii::t('kalibao.backend','product_i18n_short_description'),
            'product_i18n_long_description' =>   Yii::t('kalibao.backend','product_i18n_long_description'),
            'product_i18n_comment' =>            Yii::t('kalibao.backend','product_i18n_comment'),
            'product_i18n_page_title' =>         Yii::t('kalibao.backend','product_i18n_page_title'),
            'product_i18n_name' =>               Yii::t('kalibao.backend','product_i18n_name'),
            'product_i18n_infos_shipping' =>     Yii::t('kalibao.backend','product_i18n_infos_shipping'),
            'product_i18n_meta_description' =>   Yii::t('kalibao.backend','product_i18n_meta_description'),
            'product_i18n_meta_keywords' =>      Yii::t('kalibao.backend','product_i18n_meta_keywords'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'productI18ns' => function ($query) use ($language) {
                $query->select(['product_id', 'name', 'short_description', 'long_description', 'comment', 'page_title', 'name', 'infos_shipping', 'meta_description', 'meta_keywords'])->onCondition(['product_i18n.i18n_id' => $language]);
            },
            'brand' => function ($query) use ($language) {
                $query->select(['id', 'name']);
            },
            'supplier' => function ($query) use ($language) {
                $query->select(['id', 'name']);
            }
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'exclude_discount_code',
                    'force_secure',
                    'archived',
                    'top_product',
                    'exclude_from_google',
                    'link_brand_product',
                    'link_product_test',
                    'available',
                    'available_date',
                    'alternative_product_i18n_name' => [
                        'asc' => ['product_i18n.name' => SORT_ASC],
                        'desc' => ['product_i18n.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_name')
                    ],
                    'alternative_product',
                    'brand_name' => [
                        'asc' => ['brand.name' => SORT_ASC],
                        'desc' => ['brand.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('brand_name')
                    ],
                    'brand_id',
                    'supplier_name' => [
                        'asc' => ['supplier.name' => SORT_ASC],
                        'desc' => ['supplier.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('supplier_name')
                    ],
                    'supplier_id',
                    'catalog_category_i18n_title' => [
                        'asc' => ['category_i18n.title' => SORT_ASC],
                        'desc' => ['category_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('category_i18n_title')
                    ],
                    'catalog_category_id',
                    'stats_category_i18n_title' => [
                        'asc' => ['category_i18n.title' => SORT_ASC],
                        'desc' => ['category_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('category_i18n_title')
                    ],
                    'google_category_id',
                    'google_category_i18n_title' => [
                        'asc' => ['category_i18n.title' => SORT_ASC],
                        'desc' => ['category_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('category_i18n_title')
                    ],
                    'stats_category_id',
                    'accountant_category_i18n_title' => [
                        'asc' => ['category_i18n.title' => SORT_ASC],
                        'desc' => ['category_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('category_i18n_title')
                    ],
                    'accountant_category_id',
                    'base_price',
                    'is_pack',
                    'product_i18n_short_description' => [
                        'asc' => ['product_i18n.short_description' => SORT_ASC],
                        'desc' => ['product_i18n.short_description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_short_description')
                    ],
                    'product_i18n_long_description' => [
                        'asc' => ['product_i18n.long_description' => SORT_ASC],
                        'desc' => ['product_i18n.long_description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_long_description')
                    ],
                    'product_i18n_comment' => [
                        'asc' => ['product_i18n.comment' => SORT_ASC],
                        'desc' => ['product_i18n.comment' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_comment')
                    ],
                    'product_i18n_page_title' => [
                        'asc' => ['product_i18n.page_title' => SORT_ASC],
                        'desc' => ['product_i18n.page_title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_page_title')
                    ],
                    'product_i18n_name' => [
                        'asc' => ['product_i18n.name' => SORT_ASC],
                        'desc' => ['product_i18n.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_name')
                    ],
                    'product_i18n_infos_shipping' => [
                        'asc' => ['product_i18n.infos_shipping' => SORT_ASC],
                        'desc' => ['product_i18n.infos_shipping' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_infos_shipping')
                    ],
                    'product_i18n_meta_description' => [
                        'asc' => ['product_i18n.meta_description' => SORT_ASC],
                        'desc' => ['product_i18n.meta_description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_meta_description')
                    ],
                    'product_i18n_meta_keywords' => [
                        'asc' => ['product_i18n.meta_keywords' => SORT_ASC],
                        'desc' => ['product_i18n.meta_keywords' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('product_i18n_meta_keywords')
                    ],
                    'created_at',
                    'updated_at',
                ],
                'defaultOrder' => [
                    'updated_at' => SORT_DESC
                ]
            ],
            'pagination' => [
                'defaultPageSize' => $pageSize,
                'pageSize' => $pageSize,
            ]
        ]);

        $this->load($requestParams);

        if (! $this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['>=', 'product.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'product.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'product.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'product.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['product.id' => $this->id])
            ->andFilterWhere(['product.exclude_discount_code' => $this->exclude_discount_code])
            ->andFilterWhere(['product.force_secure' => $this->force_secure])
            ->andFilterWhere(['product.archived' => $this->archived])
            ->andFilterWhere(['product.top_product' => $this->top_product])
            ->andFilterWhere(['product.exclude_from_google' => $this->exclude_from_google])
            ->andFilterWhere(['like', 'product.link_brand_product', $this->link_brand_product])
            ->andFilterWhere(['like', 'product.link_product_test', $this->link_product_test])
            ->andFilterWhere(['product.available' => $this->available])
            ->andFilterWhere(['product.available_date' => $this->available_date])
            ->andFilterWhere(['like', 'product_i18n.name', $this->product_i18n_name])
            ->andFilterWhere(['product.alternative_product' => $this->alternative_product])
            ->andFilterWhere(['like', 'brand.name', $this->brand_name])
            ->andFilterWhere(['product.brand_id' => $this->brand_id])
            ->andFilterWhere(['like', 'supplier.name', $this->supplier_name])
            ->andFilterWhere(['product.supplier_id' => $this->supplier_id])
            ->andFilterWhere(['like', 'category_i18n.title', $this->stats_category_i18n_title])
            ->andFilterWhere(['product.google_category_id' => $this->google_category_id])
            ->andFilterWhere(['like', 'category_i18n.title', $this->google_category_i18n_title])
            ->andFilterWhere(['product.stats_category_id' => $this->stats_category_id])
            ->andFilterWhere(['like', 'category_i18n.title', $this->accountant_category_i18n_title])
            ->andFilterWhere(['product.accountant_category_id' => $this->accountant_category_id])
            ->andFilterWhere(['product.base_price' => $this->base_price])
            ->andFilterWhere(['product.is_pack' => $this->is_pack])
            ->andFilterWhere(['like', 'product_i18n.short_description', $this->product_i18n_short_description])
            ->andFilterWhere(['like', 'product_i18n.long_description', $this->product_i18n_long_description])
            ->andFilterWhere(['like', 'product_i18n.comment', $this->product_i18n_comment])
            ->andFilterWhere(['like', 'product_i18n.page_title', $this->product_i18n_page_title])
            ->andFilterWhere(['like', 'product_i18n.name', $this->product_i18n_name])
            ->andFilterWhere(['like', 'product_i18n.infos_shipping', $this->product_i18n_infos_shipping])
            ->andFilterWhere(['like', 'product_i18n.meta_description', $this->product_i18n_meta_description])
            ->andFilterWhere(['like', 'product_i18n.meta_keywords', $this->product_i18n_meta_keywords]);

        return $dataProvider;
    }
}
