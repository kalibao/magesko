<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\models\branch\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\branch\Branch;

/**
 * This is the model filter class for controller "Branch".
 *
 * @property integer $id
 * @property string $branch_type_i18n_label
 * @property integer $branch_type_id
 * @property string $tree_i18n_label
 * @property integer $tree_id
 * @property string $branch_i18n_label
 * @property integer $parent
 * @property integer $order
 * @property string $media_i18n_title
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
 * @property string $parent_i18n_label
 * @property string $branch_i18n_description
 * @property string $branch_i18n_url
 * @property string $branch_i18n_meta_title
 * @property string $branch_i18n_meta_description
 * @property string $branch_i18n_meta_keywords
 * @property string $branch_i18n_h1_tag
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\tree\models\branch\crud
 * @version 1.0
 */
class ModelFilter extends Branch implements ModelFilterInterface
{
    public $branch_type_i18n_label;
    public $tree_i18n_label;
    public $branch_i18n_label;
    public $media_i18n_title;
    public $media_file;
    public $parent_i18n_label;
    public $branch_i18n_description;
    public $branch_i18n_url;
    public $branch_i18n_meta_title;
    public $branch_i18n_meta_description;
    public $branch_i18n_meta_keywords;
    public $branch_i18n_h1_tag;
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
                'id', 'branch_type_i18n_label', 'branch_type_id', 'tree_i18n_label', 'tree_id', 'branch_i18n_label', 'parent', 'order', 'media_i18n_title', 'media_id', 'visible', 'background', 'presentation_type', 'offset', 'display_brands_types', 'big_menu_only_first_level', 'unfold', 'google_shopping_category_id', 'google_shopping', 'affiliation_category_id', 'affiliation', 'branch_i18n_label', 'branch_i18n_description', 'branch_i18n_url', 'branch_i18n_meta_title', 'branch_i18n_meta_description', 'branch_i18n_meta_keywords', 'branch_i18n_h1_tag', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'branch_type_id', 'tree_id', 'parent', 'order', 'media_id', 'offset', 'google_shopping_category_id', 'affiliation_category_id'], 'integer'],
            [['visible', 'presentation_type', 'display_brands_types', 'big_menu_only_first_level', 'unfold', 'google_shopping', 'affiliation'], 'in', 'range' => [0, 1]],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['branch_type_i18n_label'], 'string', 'max' => 50],
            [['tree_i18n_label'], 'string', 'max' => 200],
            [['branch_i18n_label', 'parent_i18n_label'], 'string', 'max' => 100],
            [['media_i18n_title'], 'string', 'max' => 255],
            [['background'], 'string', 'max' => 45],
            [['branch_i18n_description'], 'string', 'max' => 500],
            [['branch_i18n_url'], 'string', 'max' => 250],
            [['branch_i18n_meta_title'], 'string', 'max' => 1000],
            [['branch_i18n_meta_description', 'branch_i18n_meta_keywords', 'branch_i18n_h1_tag'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'branch_type_i18n_label' => Yii::t('kalibao.backend','branch_type_i18n_label'),
            'tree_i18n_label' => Yii::t('kalibao.backend','tree_i18n_label'),
            'branch_i18n_label' => Yii::t('kalibao.backend','branch_i18n_label'),
            'media_i18n_title' => Yii::t('kalibao.backend','media_i18n_title'),
            'media_file' => Yii::t('kalibao.backend','media_file'),
            'parent_i18n_label' => Yii::t('kalibao.backend','parent_i18n_label'),
            'branch_i18n_description' => Yii::t('kalibao.backend','branch_i18n_description'),
            'branch_i18n_url' => Yii::t('kalibao.backend','branch_i18n_url'),
            'branch_i18n_meta_title' => Yii::t('kalibao.backend','branch_i18n_meta_title'),
            'branch_i18n_meta_description' => Yii::t('kalibao.backend','branch_i18n_meta_description'),
            'branch_i18n_meta_keywords' => Yii::t('kalibao.backend','branch_i18n_meta_keywords'),
            'branch_i18n_h1_tag' => Yii::t('kalibao.backend','branch_i18n_h1_tag'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'branchTypeI18ns' => function ($query) use ($language) {
                $query->select(['branch_type_id', 'label'])->onCondition(['branch_type_i18n.i18n_id' => $language]);
            },
            'treeI18ns' => function ($query) use ($language) {
                $query->select(['tree_id', 'label'])->onCondition(['tree_i18n.i18n_id' => $language]);
            },
            'branchI18ns' => function ($query) use ($language) {
                $query->select(['branch_id', 'label', 'label', 'description', 'url', 'meta_title', 'meta_description', 'meta_keywords', 'h1_tag'])->onCondition(['branch_i18n.i18n_id' => $language]);
            },
            'mediaI18ns' => function ($query) use ($language) {
                $query->select(['media_id', 'title'])->onCondition(['media_i18n.i18n_id' => $language]);
            },
            'media' => function ($query) {
                $query->select(['id', 'file']);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'branch_type_i18n_label' => [
                        'asc' => ['branch_type_i18n.label' => SORT_ASC],
                        'desc' => ['branch_type_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_type_i18n_label')
                    ],
                    'branch_type_id',
                    'tree_i18n_label' => [
                        'asc' => ['tree_i18n.label' => SORT_ASC],
                        'desc' => ['tree_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('tree_i18n_label')
                    ],
                    'tree_id',
                    'branch_i18n_label' => [
                        'asc' => ['branch_i18n.label' => SORT_ASC],
                        'desc' => ['branch_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_label')
                    ],
                    'parent',
                    'order',
                    'media_i18n_title' => [
                        'asc' => ['media_i18n.title' => SORT_ASC],
                        'desc' => ['media_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('media_i18n_title')
                    ],
                    'media_file' => [
                        'asc' => ['media.file' => SORT_ASC],
                        'desc' => ['media.file' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('media_file')
                    ],
                    'media_id',
                    'visible',
                    'background',
                    'presentation_type',
                    'offset',
                    'display_brands_types',
                    'big_menu_only_first_level',
                    'unfold',
                    'google_shopping_category_id',
                    'google_shopping',
                    'affiliation_category_id',
                    'affiliation',
                    'parent_i18n_label' => [
                        'asc' => ['branch_i18n.label' => SORT_ASC],
                        'desc' => ['branch_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_label')
                    ],
                    'branch_i18n_description' => [
                        'asc' => ['branch_i18n.description' => SORT_ASC],
                        'desc' => ['branch_i18n.description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_description')
                    ],
                    'branch_i18n_url' => [
                        'asc' => ['branch_i18n.url' => SORT_ASC],
                        'desc' => ['branch_i18n.url' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_url')
                    ],
                    'branch_i18n_meta_title' => [
                        'asc' => ['branch_i18n.meta_title' => SORT_ASC],
                        'desc' => ['branch_i18n.meta_title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_meta_title')
                    ],
                    'branch_i18n_meta_description' => [
                        'asc' => ['branch_i18n.meta_description' => SORT_ASC],
                        'desc' => ['branch_i18n.meta_description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_meta_description')
                    ],
                    'branch_i18n_meta_keywords' => [
                        'asc' => ['branch_i18n.meta_keywords' => SORT_ASC],
                        'desc' => ['branch_i18n.meta_keywords' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_meta_keywords')
                    ],
                    'branch_i18n_h1_tag' => [
                        'asc' => ['branch_i18n.h1_tag' => SORT_ASC],
                        'desc' => ['branch_i18n.h1_tag' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_h1_tag')
                    ],
                    'created_at',
                    'updated_at',
                ],
                'defaultOrder' => [
                    'id' => SORT_DESC
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

        $query->andFilterWhere(['>=', 'branch.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'branch.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'branch.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'branch.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['branch.id' => $this->id])
            ->andFilterWhere(['like', 'branch_type_i18n.label', $this->branch_type_i18n_label])
            ->andFilterWhere(['branch.branch_type_id' => $this->branch_type_id])
            ->andFilterWhere(['like', 'tree_i18n.label', $this->tree_i18n_label])
            ->andFilterWhere(['branch.tree_id' => $this->tree_id])
            ->andFilterWhere(['like', 'branch_i18n.label', $this->branch_i18n_label])
            ->andFilterWhere(['branch.parent' => $this->parent])
            ->andFilterWhere(['branch.order' => $this->order])
            ->andFilterWhere(['like', 'media_i18n.title', $this->media_i18n_title])
            ->andFilterWhere(['like', 'media.file', $this->media_file])
            ->andFilterWhere(['branch.media_id' => $this->media_id])
            ->andFilterWhere(['branch.visible' => $this->visible])
            ->andFilterWhere(['like', 'branch.background', $this->background])
            ->andFilterWhere(['branch.presentation_type' => $this->presentation_type])
            ->andFilterWhere(['branch.offset' => $this->offset])
            ->andFilterWhere(['branch.display_brands_types' => $this->display_brands_types])
            ->andFilterWhere(['branch.big_menu_only_first_level' => $this->big_menu_only_first_level])
            ->andFilterWhere(['branch.unfold' => $this->unfold])
            ->andFilterWhere(['branch.google_shopping_category_id' => $this->google_shopping_category_id])
            ->andFilterWhere(['branch.google_shopping' => $this->google_shopping])
            ->andFilterWhere(['branch.affiliation_category_id' => $this->affiliation_category_id])
            ->andFilterWhere(['branch.affiliation' => $this->affiliation])
            ->andFilterWhere(['like', 'branch_i18n.label', $this->branch_i18n_label])
            ->andFilterWhere(['like', 'branch_i18n.description', $this->branch_i18n_description])
            ->andFilterWhere(['like', 'branch_i18n.url', $this->branch_i18n_url])
            ->andFilterWhere(['like', 'branch_i18n.meta_title', $this->branch_i18n_meta_title])
            ->andFilterWhere(['like', 'branch_i18n.meta_description', $this->branch_i18n_meta_description])
            ->andFilterWhere(['like', 'branch_i18n.meta_keywords', $this->branch_i18n_meta_keywords])
            ->andFilterWhere(['like', 'branch_i18n.h1_tag', $this->branch_i18n_h1_tag]);

        return $dataProvider;
    }
}
