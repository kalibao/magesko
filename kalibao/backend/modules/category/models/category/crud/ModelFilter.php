<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\category\models\category\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\category\Category;

/**
 * This is the model filter class for controller "Category".
 *
 * @property integer $id
 * @property string $parent_category_i18n_title
 * @property integer $parent
 * @property string $media_i18n_title
 * @property integer $media_id
 * @property string $category_i18n_title
 * @property string $category_i18n_description
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\category\models\category\crud
 * @version 1.0
 */
class ModelFilter extends Category implements ModelFilterInterface
{
    public $category_i18n_title;
    public $media_i18n_title;
    public $parent_category_i18n_title;
    public $category_i18n_description;
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
                'id', 'parent_category_i18n_title', 'parent', 'media_i18n_title', 'media_id', 'category_i18n_title', 'category_i18n_description', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'media_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['parent_category_i18n_title', 'category_i18n_title'], 'string', 'max' => 200],
            [['media_i18n_title'], 'string', 'max' => 255],
            [['category_i18n_description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_i18n_title' => Yii::t('kalibao.backend','category_i18n_title'),
            'media_i18n_title' => Yii::t('kalibao.backend','media_i18n_title'),
            'parent_category_i18n_title' => Yii::t('kalibao.backend','parent_category_i18n_title'),
            'category_i18n_description' => Yii::t('kalibao.backend','category_i18n_description'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'categoryI18ns' => function ($query) use ($language) {
                $query->select(['category_id', 'title', 'title', 'description'])->onCondition(['category_i18n.i18n_id' => $language]);
            },
            'mediaI18ns' => function ($query) use ($language) {
                $query->select(['media_id', 'title'])->onCondition(['media_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'category_i18n_title' => [
                        'asc' => ['category_i18n.title' => SORT_ASC],
                        'desc' => ['category_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('category_i18n_title')
                    ],
                    'parent',
                    'media_i18n_title' => [
                        'asc' => ['media_i18n.title' => SORT_ASC],
                        'desc' => ['media_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('media_i18n_title')
                    ],
                    'media_id',
                    'parent_category_i18n_title' => [
                        'asc' => ['category_i18n.title' => SORT_ASC],
                        'desc' => ['category_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('category_i18n_title')
                    ],
                    'category_i18n_description' => [
                        'asc' => ['category_i18n.description' => SORT_ASC],
                        'desc' => ['category_i18n.description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('category_i18n_description')
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

        $query->andFilterWhere(['>=', 'category.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'category.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'category.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'category.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['category.id' => $this->id])
            ->andFilterWhere(['like', 'category_i18n.title', $this->category_i18n_title])
            ->andFilterWhere(['category.parent' => $this->parent])
            ->andFilterWhere(['like', 'media_i18n.title', $this->media_i18n_title])
            ->andFilterWhere(['category.media_id' => $this->media_id])
            ->andFilterWhere(['like', 'category_i18n.title', $this->category_i18n_title])
            ->andFilterWhere(['like', 'category_i18n.description', $this->category_i18n_description]);

        return $dataProvider;
    }
}
