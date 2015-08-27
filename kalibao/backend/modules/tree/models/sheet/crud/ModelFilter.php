<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\models\sheet\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\tree\Sheet;

/**
 * This is the model filter class for controller "Sheet".
 *
 * @property integer $id
 * @property string $sheet_type_i18n_label
 * @property integer $sheet_type_id
 * @property string $branch_i18n_label
 * @property integer $branch_id
 * @property integer $primary_key
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\tree\models\sheet\crud
 * @version 1.0
 */
class ModelFilter extends Sheet implements ModelFilterInterface
{
    public $sheet_type_i18n_label;
    public $branch_i18n_label;
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
                'id', 'sheet_type_i18n_label', 'sheet_type_id', 'branch_i18n_label', 'branch_id', 'primary_key', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sheet_type_id', 'branch_id', 'primary_key'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['sheet_type_i18n_label'], 'string', 'max' => 50],
            [['branch_i18n_label'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sheet_type_i18n_label' => Yii::t('kalibao.backend','sheet_type_i18n_label'),
            'branch_i18n_label' => Yii::t('kalibao.backend','branch_i18n_label'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'sheetTypeI18ns' => function ($query) use ($language) {
                $query->select(['sheet_type_id', 'label'])->onCondition(['sheet_type_i18n.i18n_id' => $language]);
            },
            'branchI18ns' => function ($query) use ($language) {
                $query->select(['branch_id', 'label'])->onCondition(['branch_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'sheet_type_i18n_label' => [
                        'asc' => ['sheet_type_i18n.label' => SORT_ASC],
                        'desc' => ['sheet_type_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('sheet_type_i18n_label')
                    ],
                    'sheet_type_id',
                    'branch_i18n_label' => [
                        'asc' => ['branch_i18n.label' => SORT_ASC],
                        'desc' => ['branch_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('branch_i18n_label')
                    ],
                    'branch_id',
                    'primary_key',
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

        $query->andFilterWhere(['>=', 'sheet.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'sheet.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'sheet.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'sheet.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['sheet.id' => $this->id])
            ->andFilterWhere(['like', 'sheet_type_i18n.label', $this->sheet_type_i18n_label])
            ->andFilterWhere(['sheet.sheet_type_id' => $this->sheet_type_id])
            ->andFilterWhere(['like', 'branch_i18n.label', $this->branch_i18n_label])
            ->andFilterWhere(['sheet.branch_id' => $this->branch_id])
            ->andFilterWhere(['sheet.primary_key' => $this->primary_key]);

        return $dataProvider;
    }
}
