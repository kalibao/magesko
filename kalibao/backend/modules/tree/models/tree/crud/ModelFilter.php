<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\models\tree\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\tree\Tree;

/**
 * This is the model filter class for controller "tree".
 *
 * @property integer $id
 * @property string $tree_type_i18n_label
 * @property integer $tree_type_id
 * @property string $media_i18n_title
 * @property integer $media_id
 * @property string $tree_i18n_label
 * @property string $tree_i18n_description
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\tree\models\tree\crud
 * @version 1.0
 */
class ModelFilter extends Tree implements ModelFilterInterface
{
    public $tree_type_i18n_label;
    public $media_file;
    public $media_i18n_title;
    public $tree_i18n_label;
    public $tree_i18n_description;
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
                'id', 'tree_type_i18n_label', 'tree_type_id', 'media_i18n_title', 'media_file', 'media_id', 'tree_i18n_label', 'tree_i18n_description', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tree_type_id', 'media_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['tree_type_i18n_label'], 'string', 'max' => 50],
            [['media_i18n_title'], 'string', 'max' => 255],
            [['media_file'], 'string', 'max' => 255],
            [['tree_i18n_label'], 'string', 'max' => 200],
            [['tree_i18n_description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tree_type_i18n_label' => Yii::t('kalibao.backend','tree_type_i18n_label'),
            'media_i18n_title' => Yii::t('kalibao.backend','media_i18n_title'),
            'media_file' => Yii::t('kalibao.backend','media_file'),
            'tree_i18n_label' => Yii::t('kalibao.backend','tree_i18n_label'),
            'tree_i18n_description' => Yii::t('kalibao.backend','tree_i18n_description'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'treeTypeI18ns' => function ($query) use ($language) {
                $query->select(['tree_type_id', 'label'])->onCondition(['tree_type_i18n.i18n_id' => $language]);
            },
            'mediaI18ns' => function ($query) use ($language) {
                $query->select(['media_id', 'title'])->onCondition(['media_i18n.i18n_id' => $language]);
            },
            'media' => function ($query) {
                $query->select(['id', 'file']);
            },
            'treeI18ns' => function ($query) use ($language) {
                $query->select(['tree_id', 'label', 'description'])->onCondition(['tree_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'tree_type_i18n_label' => [
                        'asc' => ['tree_type_i18n.label' => SORT_ASC],
                        'desc' => ['tree_type_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('tree_type_i18n_label')
                    ],
                    'tree_type_id',
                    'media_i18n_title' => [
                        'asc' => ['media_i18n.title' => SORT_ASC],
                        'desc' => ['media_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('media_i18n_title')
                    ],
                    'media_file' => [
                        'asc' => ['media.title' => SORT_ASC],
                        'desc' => ['media.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('media_file')
                    ],
                    'media_id',
                    'tree_i18n_label' => [
                        'asc' => ['tree_i18n.label' => SORT_ASC],
                        'desc' => ['tree_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('tree_i18n_label')
                    ],
                    'tree_i18n_description' => [
                        'asc' => ['tree_i18n.description' => SORT_ASC],
                        'desc' => ['tree_i18n.description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('tree_i18n_description')
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

        $query->andFilterWhere(['>=', 'tree.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'tree.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'tree.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'tree.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['tree.id' => $this->id])
            ->andFilterWhere(['like', 'tree_type_i18n.label', $this->tree_type_i18n_label])
            ->andFilterWhere(['tree.tree_type_id' => $this->tree_type_id])
            ->andFilterWhere(['like', 'media_i18n.title', $this->media_i18n_title])
            ->andFilterWhere(['like', 'media.file', $this->media_file])
            ->andFilterWhere(['tree.media_id' => $this->media_id])
            ->andFilterWhere(['like', 'tree_i18n.label', $this->tree_i18n_label])
            ->andFilterWhere(['like', 'tree_i18n.description', $this->tree_i18n_description]);

        return $dataProvider;
    }
}
