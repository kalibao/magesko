<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\models\product;

use kalibao\common\models\branch\Branch;
use kalibao\common\models\brand\Brand;
use kalibao\common\models\bundle\Bundle;
use kalibao\common\models\product\ProductI18n;
use kalibao\common\models\productMedia\ProductMedia;
use kalibao\common\models\supplier\Supplier;
use kalibao\common\models\sheet\Sheet;
use kalibao\common\models\variant\Variant;
use kalibao\common\models\variantAttribute\VariantAttribute;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;

/**
 * This is the model class for table "product".
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
 * @property integer $alternative_product
 * @property integer $brand_id
 * @property integer $supplier_id
 * @property integer $google_category_id
 * @property integer $stats_category_id
 * @property integer $accountant_category_id
 * @property string $base_price
 * @property integer $is_pack
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Bundle[] $bundles
 * @property Brand $brand
 * @property Branch $googleCategory
 * @property Branch $statsCategory
 * @property Branch $accountantCategory
 * @property Product $alternativeProduct
 * @property Product[] $products
 * @property Supplier $supplier
 * @property ProductI18n[] $productI18ns
 * @property ProductMedia[] $productMedia
 * @property Variant[] $variants
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
            'insert'             => [
                'exclude_discount_code',
                'force_secure',
                'archived',
                'top_product',
                'exclude_from_google',
                'link_brand_product',
                'link_product_test',
                'available',
                'available_date',
                'alternative_product',
                'brand_id',
                'supplier_id',
                'google_category_id',
                'stats_category_id',
                'accountant_category_id',
                'base_price',
                'is_pack'
            ],
            'update'             => [
                'exclude_discount_code',
                'force_secure',
                'archived',
                'top_product',
                'exclude_from_google',
                'link_brand_product',
                'link_product_test',
                'available',
                'available_date',
                'alternative_product',
                'brand_id',
                'supplier_id',
                'google_category_id',
                'stats_category_id',
                'accountant_category_id',
                'base_price',
                'is_pack'
            ],
            'update_product'     => [
                'exclude_discount_code',
                'force_secure',
                'archived',
                'alternative_product',
                'brand_id',
                'supplier_id',
                'stats_category_id',
                'accountant_category_id'
            ],
            'update_description' => [],
            'update_price'       => ['base_price'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'exclude_discount_code',
                    'force_secure',
                    'archived',
                    'top_product',
                    'exclude_from_google',
                    'available',
                    'is_pack'
                ],
                'in',
                'range' => [0, 1]
            ],
            [
                [
                    'available_date',
                    'brand_id',
                    'supplier_id',
                    'google_category_id',
                    'stats_category_id',
                    'accountant_category_id',
                ],
                'required'
            ],
            [['available_date'], 'safe'],
            [
                [
                    'alternative_product',
                    'brand_id',
                    'supplier_id',
                    'google_category_id',
                    'stats_category_id',
                    'accountant_category_id'
                ],
                'integer'
            ],
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
            'brand_id'               => Yii::t('kalibao.backend', 'product_label_brand_id'),
            'supplier_id'            => Yii::t('kalibao.backend', 'product_label_supplier_id'),
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
            if ($i18n->i18n_id == Yii::$app->language) {
                return $i18n;
            }
        }
        if (array_key_exists(0, $i18ns)) {
            return $i18ns[0];
        }
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
     * function to put in cache all attribute related information
     * @return Array The array containing attributes information
     * @throws \Exception
     */
    public function getAttributeInfo()
    {
        return $this->getDb()->cache(
            function ($db) {
                $a = [];
                foreach ($this->variants as $variant) {
                    foreach ($variant->variantAttributes as $varAtt) {
                        $key = ($varAtt->attributeModel->attributeTypeI18n) ? $varAtt->attributeModel->attributeTypeI18n->value : $varAtt->attributeModel->attributeTypeI18ns[0]->value;
                        $a[$key][$varAtt->primaryKey['attribute_id']] = [
                            'value'  => ($varAtt->attributeI18n) ? $varAtt->attributeI18n->value : $varAtt->attributeI18ns[0]->value,
                            'price'  => $varAtt->extra_cost,
                            'id'     => $varAtt->primaryKey['attribute_id'],
                            'typeId' => $varAtt->attributeModel->attribute_type_id
                        ];
                    }
                }
                return $a;
            }, 0, new TagDependency([
                'tags' => [
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
            function ($db) {
                $variants = $this->variants;
                foreach ($variants as $variant) {
                    $variant->discount;
                    $variant->finalPrice;
                    $variant->variantI18n;
                    $variant->variantI18ns;
                }
                usort($variants, function ($a, $b) {
                    return $a->order - $b->order;
                });
                return $variants;
            }, 0, new TagDependency([
                'tags' => [
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
            function ($db) {
                $variants = $this->variants;
                foreach ($variants as $variant) {
                    $variant->logisticStrategy;
                    $variant->logisticStrategyI18n;
                    $variant->logisticStrategyI18ns;
                }
                usort($variants, function ($a, $b) {
                    return $a->order - $b->order;
                });
                return $variants;
            }, 0, new TagDependency([
                'tags' => [
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
            function ($db) {
                $data = [];
                $variants = $this->variants;
                foreach ($variants as $variant) {
                    $data[$variant->id] = [];
                    foreach ($variant->crossSellings as $cs) {
                        foreach ($cs->variantId2->variantAttributes as $va) {
                            $va->attributeI18ns;
                        }
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['variant'] = $cs;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['discount'] = $cs->discount;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['variant2'] = $cs->variantId2;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['product'] = $cs->variantId2->product;
                        $data[$cs->variant_id_1][$cs->variant_id_1 . '-' . $cs->variant_id_2]['producti18n'] = $cs->variantId2->productI18n;
                    }
                }
                return $data;
            }, 0, new TagDependency([
                'tags' => [
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
            function ($db) {
                $productMedia = $this->productMedia;
                if (isset($productMedia[0])) {
                    $media = $productMedia[0]->media;
                    $url = Yii::$app->cdnManager->getBaseUrl() . '/common/data/' . $media->file;
                    $alt = $media->mediaI18ns[0]->title;
                } else {
                    $url = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iOTYiIHdpZHRoPSI5NiI+PHBhdGggZD0iTTYwIDE2bDYgOEw2OCAyOEg3MmgxMmMyIDAgNCAyIDQgNHY0NGMwIDItMiA0LTQgNEgxMmMtMiAwLTQtMi00LTRWMzJjMC0yIDItNCA0LTRoMTIgNGwyLTQgNi04SDYwTTY0IDhIMzJsLTggMTJIMTJDNSAyMCAwIDI1IDAgMzJWNzZjMCA3IDUgMTIgMTIgMTJoNzJjNyAwIDEyLTUgMTItMTJWMzJjMC03LTUtMTItMTItMTJINzJMNjQgOCA2NCA4ek00OCA0MGM3IDAgMTIgNSAxMiAxMnMtNSAxMi0xMiAxMmMtNyAwLTEyLTUtMTItMTJTNDEgNDAgNDggNDBNNDggMzJjLTExIDAtMjAgOS0yMCAyMHM5IDIwIDIwIDIwYzExIDAgMjAtOSAyMC0yMFM1OSAzMiA0OCAzMkw0OCAzMnoiLz48L3N2Zz4=";
                    $alt = "No image";
                }
                return [
                    'url' => $url,
                    'alt' => $alt
                ];
            }, 0, new TagDependency([
                'tags' => [
                    $this->generateTag(),
                    $this->generateTag($this->id),
                    $this->generateTag($this->id, 'productCrossSelling')
                ]
            ])
        );
    }

    /**
     * function to put in cache all media information related to a product
     * @return array All medias in an array of type "mediaType" => [medias]
     * @throws \Exception
     */
    public function getMediaTypes()
    {
        return $this->getDb()->cache(
            function ($db) {
                $data = [];
                $productMedias = $this->productMedia;
                foreach ($productMedias as $productMedia) {
                    $productMedia->media->mediaI18ns;
                    $productMedia->media->mediaTypeI18ns;
                    $type = ($productMedia->media->mediaTypeI18n) ? $productMedia->media->mediaTypeI18n->title : $productMedia->media->media_type_id;
                    $data[$productMedia->media->media_type_id][0] = $type;
                    $data[$productMedia->media->media_type_id][1][] = $productMedia->media;
                }
                return $data;
            }, 0, new TagDependency([
                'tags' => [
                    $this->generateTag(),
                    $this->generateTag($this->id),
                    $this->generateTag($this->id, 'productMedia')
                ]
            ])
        );
    }

    public function getCategories($asJson = false)
    {
        $dependency = new TagDependency([
            'tags' => [
                $this->generateTag(),
                $this->generateTag($this->id),
                $this->generateTag($this->id, 'categories'),
            ]
        ]);
        $db = Yii::$app->db;
        $data = $db->cache(function ($db) {
            return $db->createCommand(
                "SELECT branch_id
                 FROM sheet, sheet_type
                 WHERE sheet_type_id = sheet_type.id
                   AND `table` = 'product'
                   AND primary_key = :id",
                [
                    "id" => $this->id
                ]
            )->queryAll();
        }, 0, $dependency);
        return ($asJson) ? json_encode($data) : $data;
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

    public static function countByAttribute($where = [])
    {
        $sheets = Sheet::find()
            ->innerJoinWith('sheetType')
            ->where([
                'table' => 'product'
            ])
            ->andwhere($where)
            ->select('sheet.id, sheet_type_id, primary_key')
            ->asArray()
            ->all();

        $productIds = [];
        foreach ($sheets as $sheet) {
            $productIds[] = $sheet['primary_key'];
        }

        if (empty($productIds)) {
            return false;
        }

        $command = Yii::$app->db->createCommand(
            "SELECT `attribute_id`, `attribute_type_id`, count( DISTINCT product_id) AS 'number'
             FROM `variant`
             INNER JOIN `variant_attribute`
             ON `variant`.`id` = `variant_attribute`.`variant_id`
             INNER JOIN `attribute`
             ON `variant_attribute`.`attribute_id` = `attribute`.`id`
             WHERE `product_id` IN (" . implode(',', $productIds) . ")
             GROUP BY `attribute_id`"
        );
        return $command->queryAll();
    }
}