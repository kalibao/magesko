<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\attribute\models\attribute\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\attribute\Attribute;

/**
 * This is the model filter class for controller "Attribute".
 *
 * @property integer $id
 * @property string $attribute_type_i18n_value
 * @property integer $attribute_type_id
 * @property string $attribute_i18n_value
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\attribute\models\attribute\crud
 * @version 1.0
 */
class ModelFilter extends Attribute implements ModelFilterInterface
{
    public $attribute_type_i18n_value;
    public $attribute_i18n_value;
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
                'id', 'attribute_type_i18n_value', 'attribute_type_id', 'attribute_i18n_value', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attribute_type_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['attribute_type_i18n_value', 'attribute_i18n_value'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attribute_type_i18n_value' => Yii::t('kalibao.backend','attribute_type_i18n_value'),
            'attribute_i18n_value' => Yii::t('kalibao.backend','attribute_i18n_value'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'attributeTypeI18ns' => function ($query) use ($language) {
                $query->select(['attribute_type_id', 'value'])->onCondition(['attribute_type_i18n.i18n_id' => $language]);
            },
            'attributeI18ns' => function ($query) use ($language) {
                $query->select(['attribute_id', 'value'])->onCondition(['attribute_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'attribute_type_i18n_value' => [
                        'asc' => ['attribute_type_i18n.value' => SORT_ASC],
                        'desc' => ['attribute_type_i18n.value' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('attribute_type_i18n_value')
                    ],
                    'attribute_type_id',
                    'attribute_i18n_value' => [
                        'asc' => ['attribute_i18n.value' => SORT_ASC],
                        'desc' => ['attribute_i18n.value' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('attribute_i18n_value')
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

        $query->andFilterWhere(['>=', 'attribute.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'attribute.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'attribute.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'attribute.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['attribute.id' => $this->id])
            ->andFilterWhere(['like', 'attribute_type_i18n.value', $this->attribute_type_i18n_value])
            ->andFilterWhere(['attribute.attribute_type_id' => $this->attribute_type_id])
            ->andFilterWhere(['like', 'attribute_i18n.value', $this->attribute_i18n_value]);

        return $dataProvider;
    }
}
