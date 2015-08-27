<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\category;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\media\Media;
use kalibao\common\models\category\CategoryI18n;
use kalibao\common\models\product\Product;
use kalibao\common\models\media\MediaI18n;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $media_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property Media $media
 * @property CategoryI18n[] $categoryI18ns
 * @property Product[] $products
 * @property MediaI18n[] $mediaI18ns
 *
 * @package kalibao\common\models\category
 * @version 1.0
 */
class Category extends \yii\db\ActiveRecord
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
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'parent', 'media_id'
            ],
            'update' => [
                'parent', 'media_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'media_id'], 'integer'],
            [['media_id'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','label_category_id'),
            'parent' => Yii::t('kalibao.backend','label_category_parent'),
            'media_id' => Yii::t('kalibao.backend','label_media_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent' => 'id']);
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
    public function getCategoryI18ns()
    {
        return $this->hasMany(CategoryI18n::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getCatrgoryI18n()
    {
        $i18ns = $this->categoryI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['accountant_category_id' => 'id']);
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
}
