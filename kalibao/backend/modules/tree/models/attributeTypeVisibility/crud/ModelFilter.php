<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\models\attributeTypeVisibility\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\tree\AttributeTypeVisibility;

/**
 * This is the model filter class for controller "AttributeTypeVisibility".
 *
 * @property integer $attribute_type_id
 * @property integer $branch_id
 * @property integer $attribute_type_visibility_i18n_attribute_type_id
 * @property integer $attribute_type_visibility_i18n_branch_id
 * @property string $attribute_type_visibility_i18n_label
 *
 * @package kalibao\backend\modules\tree\models\attributeTypeVisibility\crud
 * @version 1.0
 */
class ModelFilter extends AttributeTypeVisibility implements ModelFilterInterface
{
    public $branch_id;
    public $attribute_type_id;
    public $attribute_type_visibility_i18n_label;
    public $attribute_type_visibility_i18n_branch_id;
    public $attribute_type_visibility_i18n_attribute_type_id;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'attribute_type_id', 'branch_id', 'attribute_type_id', 'attribute_type_visibility_i18n_attribute_type_id', 'branch_id', 'attribute_type_visibility_i18n_branch_id', 'attribute_type_visibility_i18n_label'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_type_id', 'branch_id', 'attribute_type_id', 'attribute_type_visibility_i18n_attribute_type_id', 'branch_id', 'attribute_type_visibility_i18n_branch_id'], 'integer'],
            [['attribute_type_visibility_i18n_label'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attribute_type_id' => Yii::t('kalibao.backend','attribute_type_id'),
            'attribute_type_visibility_i18n_attribute_type_id' => Yii::t('kalibao.backend','attribute_type_visibility_i18n_attribute_type_id'),
            'branch_id' => Yii::t('kalibao.backend','branch_id'),
            'attribute_type_visibility_i18n_branch_id' => Yii::t('kalibao.backend','attribute_type_visibility_i18n_branch_id'),
            'attribute_type_visibility_i18n_label' => Yii::t('kalibao.backend','attribute_type_visibility_i18n_label'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'attributeType' => function ($query) use ($language) {
                $query->select(['id', 'id']);
            },
            'attributeTypeVisibilityI18ns' => function ($query) use ($language) {
                $query->select(['attribute_type_id', 'attribute_type_id', 'branch_id', 'label'])->onCondition(['attribute_type_visibility_i18n.i18n_id' => $language]);
            },
            'branch' => function ($query) use ($language) {
                $query->select(['id', 'id']);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'attribute_type_id',
                    'branch_id',
                    'attribute_type_id' => [
                        'asc' => ['attribute_type.id' => SORT_ASC],
                        'desc' => ['attribute_type.id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('attribute_type_id')
                    ],
                    'attribute_type_visibility_i18n_attribute_type_id' => [
                        'asc' => ['attribute_type_visibility_i18n.attribute_type_id' => SORT_ASC],
                        'desc' => ['attribute_type_visibility_i18n.attribute_type_id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('attribute_type_visibility_i18n_attribute_type_id')
                    ],
                    'branch_id' => [
                        'asc' => ['branch.id' => SORT_ASC],
                        'desc' => ['branch.id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_id')
                    ],
                    'attribute_type_visibility_i18n_branch_id' => [
                        'asc' => ['attribute_type_visibility_i18n.branch_id' => SORT_ASC],
                        'desc' => ['attribute_type_visibility_i18n.branch_id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('attribute_type_visibility_i18n_branch_id')
                    ],
                    'attribute_type_visibility_i18n_label' => [
                        'asc' => ['attribute_type_visibility_i18n.label' => SORT_ASC],
                        'desc' => ['attribute_type_visibility_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('attribute_type_visibility_i18n_label')
                    ],
                ],
                'defaultOrder' => [
                    'attribute_type_id' => SORT_DESC
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


        $query
            ->andFilterWhere(['attribute_type_visibility.attribute_type_id' => $this->attribute_type_id])
            ->andFilterWhere(['attribute_type_visibility.branch_id' => $this->branch_id])
            ->andFilterWhere(['attribute_type.id' => $this->attribute_type_id])
            ->andFilterWhere(['attribute_type_visibility_i18n.attribute_type_id' => $this->attribute_type_visibility_i18n_attribute_type_id])
            ->andFilterWhere(['branch.id' => $this->branch_id])
            ->andFilterWhere(['attribute_type_visibility_i18n.branch_id' => $this->attribute_type_visibility_i18n_branch_id])
            ->andFilterWhere(['like', 'attribute_type_visibility_i18n.label', $this->attribute_type_visibility_i18n_label]);

        return $dataProvider;
    }
}
