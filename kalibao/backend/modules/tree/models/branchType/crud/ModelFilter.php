<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\models\branchType\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\branchType\BranchType;

/**
 * This is the model filter class for controller "BranchType".
 *
 * @property integer $id
 * @property string $url
 * @property string $branch_type_i18n_label
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\tree\models\branchType\crud
 * @version 1.0
 */
class ModelFilter extends BranchType implements ModelFilterInterface
{
    public $branch_type_i18n_label;
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
                'id', 'url', 'branch_type_i18n_label', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['url'], 'string', 'max' => 200],
            [['branch_type_i18n_label'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'branch_type_i18n_label' => Yii::t('kalibao.backend','branch_type_i18n_label'),
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
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'url',
                    'branch_type_i18n_label' => [
                        'asc' => ['branch_type_i18n.label' => SORT_ASC],
                        'desc' => ['branch_type_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_type_i18n_label')
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

        $query->andFilterWhere(['>=', 'branch_type.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'branch_type.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'branch_type.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'branch_type.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['branch_type.id' => $this->id])
            ->andFilterWhere(['like', 'branch_type.url', $this->url])
            ->andFilterWhere(['like', 'branch_type_i18n.label', $this->branch_type_i18n_label]);

        return $dataProvider;
    }
}
