<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\branch;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\attributeTypeVisibility\AttributeTypeVisibility;
use kalibao\common\models\affiliationCategory\AffiliationCategory;
use kalibao\common\models\branchType\BranchType;
use kalibao\common\models\googleShoppingCategory\GoogleShoppingCategory;
use kalibao\common\models\media\Media;
use kalibao\common\models\tree\Tree;
use kalibao\common\models\branch\BranchI18n;
use kalibao\common\models\sheet\Sheet;
use kalibao\common\models\branchType\BranchTypeI18n;
use kalibao\common\models\media\MediaI18n;
use kalibao\common\models\tree\TreeI18n;
use yii\caching\TagDependency;
use yii\helpers\Html;

/**
 * This is the model class for table "branch".
 *
 * @property integer $id
 * @property integer $branch_type_id
 * @property integer $tree_id
 * @property integer $parent_id
 * @property integer $order
 * @property integer $media_id
 * @property integer $visible
 * @property string $background
 * @property integer $presentation_type
 * @property integer $offset
 * @property integer $display_brands_types
 * @property integer $big_menu_only_first_level
 * @property integer $unfold
 * @property integer $google_shopping_category_id
 * @property integer $google_shopping
 * @property integer $affiliation_category_id
 * @property integer $affiliation
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AttributeTypeVisibility[] $attributeTypeVisibilities
 * @property AffiliationCategory $affiliationCategory
 * @property Branch $parent
 * @property Branch[] $branches
 * @property BranchType $branchType
 * @property GoogleShoppingCategory $googleShoppingCategory
 * @property Media $media
 * @property Tree $tree
 * @property BranchI18n[] $branchI18ns
 * @property Sheet[] $sheets
 * @property BranchTypeI18n[] $branchTypeI18ns
 * @property MediaI18n[] $mediaI18ns
 * @property TreeI18n[] $treeI18ns
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class Branch extends \yii\db\ActiveRecord
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
        return 'branch';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'branch_type_id', 'tree_id', 'parent', 'order', 'media_id', 'visible', 'background', 'presentation_type', 'offset', 'display_brands_types', 'big_menu_only_first_level', 'unfold', 'google_shopping_category_id', 'google_shopping', 'affiliation_category_id', 'affiliation'
            ],
            'update' => [
                'branch_type_id', 'tree_id', 'parent', 'order', 'media_id', 'visible', 'background', 'presentation_type', 'offset', 'display_brands_types', 'big_menu_only_first_level', 'unfold', 'google_shopping_category_id', 'google_shopping', 'affiliation_category_id', 'affiliation'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_type_id', 'tree_id'], 'required'],
            [['branch_type_id', 'tree_id', 'parent', 'order', 'media_id', 'offset', 'google_shopping_category_id', 'affiliation_category_id'], 'integer'],
            [['visible', 'presentation_type', 'display_brands_types', 'big_menu_only_first_level', 'unfold', 'google_shopping', 'affiliation'], 'in', 'range' => [0, 1]],
            [['background'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'branch_type_id' => Yii::t('kalibao.backend','Branch Type ID'),
            'tree_id' => Yii::t('kalibao.backend','Tree ID'),
            'parent' => Yii::t('kalibao.backend','sets the parent of this branch'),
            'order' => Yii::t('kalibao.backend','sets the order for branches of the same level'),
            'media_id' => Yii::t('kalibao.backend','Media ID'),
            'visible' => Yii::t('kalibao.backend','sets the visibility of the branch'),
            'background' => Yii::t('kalibao.backend','background color of the branch (used in back office only)'),
            'presentation_type' => Yii::t('kalibao.backend','sets the display mode for the sheets of this branch (table, list...)'),
            'offset' => Yii::t('kalibao.backend','sets the permission level required to access this branch'),
            'display_brands_types' => Yii::t('kalibao.backend','Display Brands Types'),
            'big_menu_only_first_level' => Yii::t('kalibao.backend','sets if all children branches must be shown in big menu'),
            'unfold' => Yii::t('kalibao.backend','Unfold'),
            'google_shopping_category_id' => Yii::t('kalibao.backend','Google Shopping Category ID'),
            'google_shopping' => Yii::t('kalibao.backend','sets if google shopping is used for this branch'),
            'affiliation_category_id' => Yii::t('kalibao.backend','Affiliation Category ID'),
            'affiliation' => Yii::t('kalibao.backend','sets if affiliation categories are used for this branch'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeTypeVisibilities()
    {
        return $this->hasMany(AttributeTypeVisibility::className(), ['branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAffiliationCategory()
    {
        return $this->hasOne(AffiliationCategory::className(), ['id' => 'affiliation_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Branch::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchType()
    {
        return $this->hasOne(BranchType::className(), ['id' => 'branch_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoogleShoppingCategory()
    {
        return $this->hasOne(GoogleShoppingCategory::className(), ['id' => 'google_shopping_category_id']);
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
    public function getTree()
    {
        return $this->hasOne(Tree::className(), ['id' => 'tree_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchI18ns()
    {
        return $this->hasMany(BranchI18n::className(), ['branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheets()
    {
        return $this->hasMany(Sheet::className(), ['branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchTypeI18ns()
    {
        return $this->hasMany(BranchTypeI18n::className(), ['branch_type_id' => 'branch_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaI18ns()
    {
        return $this->hasMany(MediaI18n::className(), ['media_id' => 'media_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeI18ns()
    {
        return $this->hasMany(TreeI18n::className(), ['tree_id' => 'tree_id']);
    }

    /**
     * creates a correct html rendering depending on the file type :
     * if the file is a picture, it will be displayed
     * if the file is anything else, a link to the resource will be displayed.
     *
     * @param $file string file to put in the row
     * @return string the file field
     */
    public function getFileTag() {
        if (!isset($this->mediaI18ns[0])) return Yii::t('kalibao.backend', 'no-image');
        $filepath = Yii::$app->cdnManager->getBaseUrl() . '/common/data/' . $this->media->file;
        $text = isset($this->mediaI18ns[0]) ? $this->mediaI18ns[0]->title : $this->media->file;
        if (in_array(
            strtolower(pathinfo($filepath)['extension']),
            ['jpg', 'png', 'gif', '']))
            $text =  Html::img(
                $filepath,
                [
                    'alt' => isset($this->mediaI18ns[0]) ? $this->mediaI18ns[0]->title : $this->media->file,
                    'height' => '100px',
                    'class' => 'thumbnail center-block'
                ]
            );
        return Html::a(
            $text,
            $filepath,
            [
                'target' => '_blank'
            ]
        );
    }

    public function getAttributeList()
    {
        TagDependency::invalidate(Yii::$app->commonCache, $this->generateTag());
        $dependency = new TagDependency(['tags' => [
            $this->generateTag(),
            $this->generateTag($this->id),
            $this->generateTag($this->id, 'attributeTypeList'),
        ]]);
        return $this->getDb()->cache(function(){
            $attributeTypes = $this->attributeTypeVisibilities;
            $list = [];
            foreach ($attributeTypes as $attributeType) {
                $list[] = [
                    'id'    => $attributeType->attribute_type_id,
                    'i18n'  => $attributeType->attributeTypeI18ns[0]->value,
                    'label' => $attributeType->attributeTypeVisibilityI18ns[0]->label
                ];
            }
            return $list;
        }, 0, $dependency);
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
        return (md5('BranchTag' . $id . $context . Yii::$app->language));
    }
}
