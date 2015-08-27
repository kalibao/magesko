<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\variable\models\variable\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\variable\Variable;

/**
 * This is the model filter class for controller "Variable".
 *
 * @property string $id
 * @property string $variable_group_i18n_title
 * @property integer $variable_group_id
 * @property string $name
 * @property string $val
 * @property string $variable_i18n_description
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\variable\models\variable\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends Variable implements ModelFilterInterface
{
    public $variable_group_i18n_title;
    public $variable_i18n_description;
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
                'id', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end',
                'variable_group_id', 'variable_group_i18n_title', 'name', 'variable_i18n_description', 'val'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'variable_group_id'], 'integer'],
            [['val', 'variable_i18n_description'], 'string'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['variable_group_i18n_title'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['variable_group_i18n_title'] = Yii::t('kalibao','variable:variable_group_id');
        $attributeLabels['variable_i18n_description'] = Yii::t('kalibao','model:description');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();

        $query->joinWith([
            'variableGroupI18ns' => function ($query) use ($language) {
                $query->select(['variable_group_id', 'title'])->onCondition(['variable_group_i18n.i18n_id' => $language]);
            },
            'variableI18ns' => function ($query) use ($language) {
                $query->select(['variable_id', 'description'])->onCondition(['variable_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'variable_group_i18n_title' => [
                        'asc' => ['variable_group_i18n.title' => SORT_ASC],
                        'desc' => ['variable_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('variable_group_i18n_title')
                    ],
                    'variable_group_id',
                    'name' => [
                        'label' => $this->getAttributeLabel('name')
                    ],
                    'val' => [
                        'label' => $this->getAttributeLabel('val')
                    ],
                    'variable_i18n_description' => [
                        'asc' => ['variable_i18n.description' => SORT_ASC],
                        'desc' => ['variable_i18n.description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('variable_i18n_description')
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

        $query->andFilterWhere(['>=', 'variable.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'variable.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'variable.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'variable.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['variable.id' => $this->id])
            ->andFilterWhere(['like', 'variable_group_i18n.title', $this->variable_group_i18n_title])
            ->andFilterWhere(['variable.variable_group_id' => $this->variable_group_id])
            ->andFilterWhere(['like', 'variable.name', $this->name])
            ->andFilterWhere(['like', 'variable.val', $this->val])
            ->andFilterWhere(['like', 'variable_i18n.description', $this->variable_i18n_description]);

        return $dataProvider;
    }
}
