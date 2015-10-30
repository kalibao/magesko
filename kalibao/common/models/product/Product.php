<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\product;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\bundle\Bundle;
use kalibao\common\models\brand\Brand;
use kalibao\common\models\category\Category;
use kalibao\common\models\supplier\Supplier;
use kalibao\common\models\product\ProductI18n;
use kalibao\common\models\productMedia\ProductMedia;
use kalibao\common\models\variant\Variant;
use kalibao\common\models\category\CategoryI18n;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\oci\QueryBuilder;
use yii\db\Query;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $exclude_discount_code
 * @property integer $force_secure
 * @property integer $archived
 * @property integer $top_product
 * @property integer $exclude_from_google
 * @property string  $link_brand_product
 * @property string  $link_product_test
 * @property integer $available
 * @property string  $available_date
 * @property integer $alternative_product
 * @property integer $lidoli_category_id
 * @property integer $brand_id
 * @property integer $supplier_id
 * @property integer $catalog_category_id
 * @property integer $google_category_id
 * @property integer $stats_category_id
 * @property integer $accountant_category_id
 * @property string  $base_price
 * @property integer $is_pack
 * @property string  $created_at
 * @property string  $updated_at
 *
 * @property Bundle[] $bundles
 * @property Brand $brand
 * @property Category $catalogCategory
 * @property Category $googleCategory
 * @property Category $statsCategory
 * @property Category $accountantCategory
 * @property Product $alternativeProduct
 * @property Product[] $products
 * @property Supplier $supplier
 * @property ProductI18n[] $productI18ns
 * @property ProductMedia[] $productMedia
 * @property Variant[] $variants
 * @property CategoryI18n[] $categoryI18ns
 *
 * @package kalibao\common\models\product
 * @version 1.0
 */
class Product extends \yii\db\ActiveRecord
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
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'exclude_discount_code', 'force_secure', 'archived', 'top_product', 'exclude_from_google', 'link_brand_product', 'link_product_test', 'available', 'available_date', 'alternative_product', 'lidoli_category_id', 'brand_id', 'supplier_id', 'catalog_category_id', 'google_category_id', 'stats_category_id', 'accountant_category_id', 'base_price', 'is_pack'
            ],
            'update' => [
                'exclude_discount_code', 'force_secure', 'archived', 'top_product', 'exclude_from_google', 'link_brand_product', 'link_product_test', 'available', 'available_date', 'alternative_product', 'lidoli_category_id', 'brand_id', 'supplier_id', 'catalog_category_id', 'google_category_id', 'stats_category_id', 'accountant_category_id', 'base_price', 'is_pack'
            ],
            'update_product' => [
                'exclude_discount_code', 'force_secure', 'archived', 'alternative_product', 'brand_id', 'supplier_id', 'stats_category_id', 'accountant_category_id'
            ],
            'update_description' => [],
            'update_price' => ['base_price'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exclude_discount_code', 'force_secure', 'archived', 'top_product', 'exclude_from_google', 'available', 'is_pack'], 'in', 'range' => [0, 1]],
            [['available_date', 'lidoli_category_id', 'brand_id', 'supplier_id', 'catalog_category_id', 'google_category_id', 'stats_category_id', 'accountant_category_id', 'base_price'], 'required'],
            [['available_date'], 'date', 'format' => 'yyyy-MM-dd'],
            [['alternative_product', 'lidoli_category_id', 'brand_id', 'supplier_id', 'catalog_category_id', 'google_category_id', 'stats_category_id', 'accountant_category_id'], 'integer'],
            [['base_price'], 'number'],
            [['link_brand_product', 'link_product_test'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                     => Yii::t('kalibao.backend', 'product_label_id'),
            'exclude_discount_code'  => Yii::t('kalibao.backend', 'product_label_exclude_discount_code'),
            'force_secure'           => Yii::t('kalibao.backend', 'product_label_force_secure'),
            'archived'               => Yii::t('kalibao.backend', 'product_label_archived'),
            'top_product'            => Yii::t('kalibao.backend', 'product_label_top_product'),
            'exclude_from_google'    => Yii::t('kalibao.backend', 'product_label_exclude_from_google'),
            'link_brand_product'     => Yii::t('kalibao.backend', 'product_label_link_brand_product'),
            'link_product_test'      => Yii::t('kalibao.backend', 'product_label_link_product_test'),
            'available'              => Yii::t('kalibao.backend', 'product_label_available'),
            'available_date'         => Yii::t('kalibao.backend', 'product_label_available_date'),
            'alternative_product'    => Yii::t('kalibao.backend', 'product_label_alternative_product'),
            'lidoli_category_id'     => Yii::t('kalibao.backend', 'product_label_lidoli_category_id'),
            'brand_id'               => Yii::t('kalibao.backend', 'product_label_brand_id'),
            'supplier_id'            => Yii::t('kalibao.backend', 'product_label_supplier_id'),
            'catalog_category_id'    => Yii::t('kalibao.backend', 'product_label_catalog_category_id'),
            'google_category_id'     => Yii::t('kalibao.backend', 'product_label_google_category_id'),
            'stats_category_id'      => Yii::t('kalibao.backend', 'product_label_stats_category_id'),
            'accountant_category_id' => Yii::t('kalibao.backend', 'product_label_accountant_category_id'),
            'base_price'             => Yii::t('kalibao.backend', 'product_label_base_price'),
            'is_pack'                => Yii::t('kalibao.backend', 'product_label_is_pack'),
            'created_at'             => Yii::t('kalibao', 'model:created_at'),
            'updated_at'             => Yii::t('kalibao', 'model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBundles()
    {
        return $this->hasMany(Bundle::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'catalog_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoogleCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'google_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatsCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'stats_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountantCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'accountant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlternativeProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'alternative_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['alternative_product' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductI18ns()
    {
        return $this->hasMany(ProductI18n::className(), ['product_id' => 'id']);
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
    public function getProductMedia()
    {
        return $this->hasMany(ProductMedia::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariants()
    {
        return $this->hasMany(Variant::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryI18ns()
    {
        return $this->hasMany(CategoryI18n::className(), ['category_id' => 'catalog_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getCategoryI18n()
    {
        $i18ns = $this->categoryI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }

    /**
     * function to put in cache all attribute related information
     * @return Array The array containing attributes information
     * @throws \Exception
     */
    public function getAttributeInfo()
    {
        return $this->getDb()->cache(
            function($db) {
                $a = [];
                foreach($this->variants as $variant) {
                    foreach($variant->variantAttributes as $varAtt) {
                        $key = ($varAtt->attributeModel->attributeTypeI18n)?$varAtt->attributeModel->attributeTypeI18n->value:$varAtt->attributeModel->attributeTypeI18ns[0]->value;
                        $a[$key][$varAtt->primaryKey['attribute_id']] = [
                            'value'  => ($varAtt->attributeI18n)?$varAtt->attributeI18n->value:$varAtt->attributeI18ns[0]->value,
                            'price'  => $varAtt->extra_cost,
                            'id'     => $varAtt->primaryKey['attribute_id'],
                            'typeId' => $varAtt->attributeModel->attribute_type_id
                        ];
                    }
                }
                return $a;
            }, 0, new TagDependency(['tags' => [
                $this->generateTag(),
                $this->generateTag($this->id),
                $this->generateTag($this->id, 'productAttribute')
                ]
            ])
        );
    }

    /**
     * function to put in cache all variant related information
     * @return Array The array containing variants information
     * @throws \Exception
     */
    public function getVariantList()
    {
        return $this->getDb()->cache(
            function($db) {
                $variants = $this->variants;
                foreach ($variants as $variant){
                    $variant->discount;
                    $variant->finalPrice;
                    $variant->variantI18n;
                    $variant->variantI18ns;
                }
                usort($variants, function($a,$b){return $a->order - $b->order;});
                return $variants;
            }, 0, new TagDependency(['tags' => [
                $this->generateTag(),
                $this->generateTag($this->id),
                $this->generateTag($this->id, 'productVariant')
            ]
            ])
        );
    }

    /**
     * function to put in cache all logistic strategy related information
     * @return Array The array containing logistic strategy information
     * @throws \Exception
     */
    public function getLogisticStrategy()
    {
        return $this->getDb()->cache(
            function($db) {
                $variants = $this->variants;
                foreach ($variants as $variant){
                    $variant->logisticStrategy;
                    $variant->logisticStrategyI18n;
                    $variant->logisticStrategyI18ns;
                }
                usort($variants, function($a,$b){return $a->order - $b->order;});
                return $variants;
            }, 0, new TagDependency(['tags' => [
                $this->generateTag(),
                $this->generateTag($this->id),
                $this->generateTag($this->id, 'productLogisticStrategy')
            ]
            ])
        );
    }

    /**
     * function to put in cache all cross selling related information
     * @return Array The array containing cross selling information
     * @throws \Exception
     */
    public function getCrossSellingInfo()
    {
        return $this->getDb()->cache(
            function($db) {
                $data = [];
                $variants = $this->variants;
                foreach($variants as $variant) {
                    $data[$variant->id] = [];
                    foreach ($variant->crossSellings as $cs) {
                        foreach ($cs->variantId2->variantAttributes as $va) {
                            $va->attributeI18ns;
                        }
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['variant']     = $cs;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['discount']    = $cs->discount;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['variant2']    = $cs->variantId2;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['product']     = $cs->variantId2->product;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['producti18n'] = $cs->variantId2->productI18n;
                    }
                }
                return $data;
            }, 0, new TagDependency(['tags' => [
                $this->generateTag(),
                $this->generateTag($this->id),
                $this->generateTag($this->id, 'productCrossSelling')
            ]
            ])
        );
    }

    /**
     * function to put in cache the thumbnail for the product.
     * If the product has medias, one of the medias is used, else, a default image is used
     * @return Array The array containing attributes information
     * @throws \Exception
     */
    public function getThumbnailInfo()
    {
        return $this->getDb()->cache(
            function($db) {
                $productMedia = $this->productMedia;
                if(isset($productMedia[0])) {
                    $media = $productMedia[0]->media;
                    $url = Yii::$app->cdnManager->getBaseUrl() . '/common/data/' . $media->file;
                    $alt = $media->mediaI18ns[0]->title;
                } else {
                    $url = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIxN3B4IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAyMiAxNyIgd2lkdGg9IjIycHgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48dGl0bGUvPjxkZWZzPjxwYXRoIGQ9Ik0xNS41ODI0MTM5LDMuOTU4MzY5NDQgTDE5Ljk4ODg4ODksMy45NTgzNjk0NCBDMTkuOTg4ODg4OSwzLjk1ODM2OTQ0IDIxLDMuOTU4MzY5NDQgMjEsNC45NzY4ODc5NSBMMjEsMTQuOTM5ODUwOSBDMjEsMTUuOTU4MzY5NCAxOS45ODg4ODg5LDE1Ljk1ODM2OTQgMTkuOTg4ODg4OSwxNS45NTgzNjk0IEwyLjAxMTExMTExLDE1Ljk1ODM2OTQgQzIuMDExMTExMTEsMTUuOTU4MzY5NCAxLDE1Ljk1ODM2OTQgMSwxNC45Mzk4NTA5IEwxLDQuOTc2ODg3OTUgQzEsMy45NTgzNjk0NCAyLjAxMTExMTExLDMuOTU4MzY5NDQgMi4wMTExMTExMSwzLjk1ODM2OTQ0IEw3LjQ3MzY2MjM0LDMuOTU4MzY5NDQgTDguNTg3MjA2ODQsMS45NTgzNjk0NCBMMTQuMzE0OTI5LDEuOTU4MzY5NDQgTDE1LjU4MjQxMzksMy45NTgzNjk0NCBaIE0xNi4yLDIuOTU4MzY5NDQgTDIwLDIuOTU4MzY5NDQgQzIwLDIuOTU4MzY5NDQgMjIsMi45NTgzNjk0NCAyMiw0Ljk1ODM2OTQzIEwyMiwxNC45NTgzNjk0IEMyMiwxNi45NTgzNjk0IDIwLDE2Ljk1ODM2OTQgMjAsMTYuOTU4MzY5NCBMMiwxNi45NTgzNjk0IEMyLDE2Ljk1ODM2OTQgMCwxNi45NTgzNjk0IDAsMTQuOTU4MzY5NCBMMCw0Ljk1ODM2OTQzIEMwLDIuOTU4MzY5NDQgMiwyLjk1ODM2OTQ0IDIsMi45NTgzNjk0NCBMNi44LDIuOTU4MzY5NDQgTDcuNzM4NzE5OTUsMS4zOTM4MzYyMSBDNy44ODIyOTc1MiwxLjE1NDU0MDI1IDguMjI1MzkwMDUsMC45NTgzNjk0NCA4LjUwMzQyMjc1LDAuOTU4MzY5NDQgTDE0LjQ5NjU3NzMsMC45NTgzNjk0NCBDMTQuNzY3MDk3NSwwLjk1ODM2OTQ0IDE1LjExNjk3OTEsMS4xNTMzMzQ1NSAxNS4yNjEyODAxLDEuMzkzODM2MjEgTDE2LjIsMi45NTgzNjk0NCBMMTYuMiwyLjk1ODM2OTQ0IFogTTExLjUsMTMuOTU4MzY5NCBDMTMuOTg1MjgxNSwxMy45NTgzNjk0IDE2LDExLjk0MzY1MDkgMTYsOS40NTgzNjk0NCBDMTYsNi45NzMwODc5NSAxMy45ODUyODE1LDQuOTU4MzY5NDQgMTEuNSw0Ljk1ODM2OTQ0IEM5LjAxNDcxODUxLDQuOTU4MzY5NDQgNyw2Ljk3MzA4Nzk1IDcsOS40NTgzNjk0NCBDNywxMS45NDM2NTA5IDkuMDE0NzE4NTEsMTMuOTU4MzY5NCAxMS41LDEzLjk1ODM2OTQgWiBNMTEuNSwxMi45NTgzNjk0IEMxMy40MzI5OTY3LDEyLjk1ODM2OTQgMTUsMTEuMzkxMzY2MSAxNSw5LjQ1ODM2OTQ0IEMxNSw3LjUyNTM3MjczIDEzLjQzMjk5NjcsNS45NTgzNjk0NCAxMS41LDUuOTU4MzY5NDQgQzkuNTY3MDAzMjksNS45NTgzNjk0NCA4LDcuNTI1MzcyNzMgOCw5LjQ1ODM2OTQ0IEM4LDExLjM5MTM2NjEgOS41NjcwMDMyOSwxMi45NTgzNjk0IDExLjUsMTIuOTU4MzY5NCBaIE0xNyw2Ljk1ODM2OTQ0IEMxNy41NTIyODQ4LDYuOTU4MzY5NDQgMTgsNi41MTA2NTQyMSAxOCw1Ljk1ODM2OTQ0IEMxOCw1LjQwNjA4NDY3IDE3LjU1MjI4NDgsNC45NTgzNjk0NCAxNyw0Ljk1ODM2OTQ0IEMxNi40NDc3MTUyLDQuOTU4MzY5NDQgMTYsNS40MDYwODQ2NyAxNiw1Ljk1ODM2OTQ0IEMxNiw2LjUxMDY1NDIxIDE2LjQ0NzcxNTIsNi45NTgzNjk0NCAxNyw2Ljk1ODM2OTQ0IFogTTQuMjIxNjc2NTgsMS40NTgzNjk0NCBDNC4wOTkyNDgsMS40NTgzNjk0NCA0LDEuNTQ3MTEyNzcgNCwxLjY1ODMzMDk0IEw0LDIuMjU4NDA3OTQgQzQsMi4zNjg4NDM2MyA0LjA5OTE4MDMxLDIuNDU4MzY5NDQgNC4yMjE2NzY1OCwyLjQ1ODM2OTQ0IEw1Ljc3ODMyMzQyLDIuNDU4MzY5NDQgQzUuOTAwNzUyLDIuNDU4MzY5NDQgNiwyLjM2OTYyNjExIDYsMi4yNTg0MDc5NCBMNiwxLjY1ODMzMDk0IEM2LDEuNTQ3ODk1MjUgNS45MDA4MTk2OSwxLjQ1ODM2OTQ0IDUuNzc4MzIzNDIsMS40NTgzNjk0NCBMNC4yMjE2NzY1OCwxLjQ1ODM2OTQ0IFoiIGlkPSJwYXRoLTEiLz48L2RlZnM+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBpZD0ibWl1IiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSI+PGcgaWQ9ImRldmljZV9jYW1lcmFfY2FwdHVyZV9waG90b19vdXRsaW5lX3N0cm9rZSI+PHVzZSBmaWxsPSIjMDAwMDAwIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHhsaW5rOmhyZWY9IiNwYXRoLTEiLz48dXNlIGZpbGw9Im5vbmUiIHhsaW5rOmhyZWY9IiNwYXRoLTEiLz48L2c+PC9nPjwvc3ZnPg==";
                    $alt = "No image";
                }
                return [
                    'url' => $url,
                    'alt' => $alt
                ];
            }, 0, new TagDependency(['tags' => [
                $this->generateTag(),
                $this->generateTag($this->id),
                $this->generateTag($this->id, 'productCrossSelling')
            ]
            ])
        );
    }

    /**
     * function to put in cache all media information related to a product
     * @return Array All medias in an array of type "mediaType" => [medias]
     * @throws \Exception
     */
    public function getMediaTypes()
    {
        return $this->getDb()->cache(
            function($db) {
                $data = [];
                $productMedias = $this->productMedia;
                foreach ($productMedias as $productMedia) {
                    $productMedia->media->mediaI18ns;
                    $productMedia->media->mediaTypeI18ns;
                    $type = ($productMedia->media->mediaTypeI18n)?$productMedia->media->mediaTypeI18n->title:$productMedia->media->media_type_id;
                    $data[$type][] = $productMedia->media;
                }
                return $data;
            }, 0, new TagDependency(['tags' => [
                $this->generateTag(),
                $this->generateTag($this->id),
                $this->generateTag($this->id, 'productMedia')
            ]
            ])
        );
    }

    public function getCategories($asJson = false)
    {
        $dependency = new TagDependency(['tags' => [
            $this->generateTag(),
            $this->generateTag($this->id),
            $this->generateTag($this->id, 'categories'),
        ]]);
        $db = Yii::$app->db;
        $data = $db->cache(function($db){
            return $db->createCommand(
                "select branch_id
                 from sheet, sheet_type
                 where sheet_type_id = sheet_type.id
                   and `table` = 'product'
                   and primary_key = :id",
                [
                    "id"    => $this->id
                ]
            )->queryAll();
        }, 0, $dependency);
        return ($asJson)?json_encode($data):$data;
    }

    /**
     * function to generate a tag for caching data (alias to static method)
     * @param string $id id of the product
     * @param string $context identifier describing the cached data
     * @return string the tag
     */
    public function generateTag($id = '', $context = '')
    {
        return self::generateTagStatic($id, $context);
    }

    /**
     * static function to generate a tag for caching data
     * @param string $id id of the product
     * @param string $context identifier describing the cached data
     * @return string the tag
     */
    public static function generateTagStatic($id = '', $context = '')
    {
        return (md5('ProductTag' . $id . $context));
    }
}