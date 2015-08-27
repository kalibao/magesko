<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\models\company\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\company\Company;

/**
 * This is the model filter class for controller "Company".
 *
 * @property integer $third_id
 * @property string $company_type_i18n_title
 * @property integer $company_type
 * @property string $name
 * @property string $tva_number
 * @property string $naf
 * @property string $siren
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\third\models\company\crud
 * @version 1.0
 */
class ModelFilter extends Company implements ModelFilterInterface
{
    public $company_type_i18n_title;
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
                'third_id', 'company_type_i18n_title', 'company_type', 'name', 'tva_number', 'naf', 'siren', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['third_id', 'company_type'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['company_type_i18n_title'], 'string', 'max' => 255],
            [['name', 'tva_number', 'naf', 'siren'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_type_i18n_title' => Yii::t('kalibao.backend','company_type_i18n_title'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'companyTypeI18ns' => function ($query) use ($language) {
                $query->select(['company_type_id', 'title'])->onCondition(['company_type_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'third_id',
                    'company_type_i18n_title' => [
                        'asc' => ['company_type_i18n.title' => SORT_ASC],
                        'desc' => ['company_type_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('company_type_i18n_title')
                    ],
                    'company_type',
                    'name',
                    'tva_number',
                    'naf',
                    'siren',
                    'created_at',
                    'updated_at',
                ],
                'defaultOrder' => [
                    'third_id' => SORT_DESC
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

        $query->andFilterWhere(['>=', 'company.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'company.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'company.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'company.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['company.third_id' => $this->third_id])
            ->andFilterWhere(['like', 'company_type_i18n.title', $this->company_type_i18n_title])
            ->andFilterWhere(['company.company_type' => $this->company_type])
            ->andFilterWhere(['like', 'company.name', $this->name])
            ->andFilterWhere(['like', 'company.tva_number', $this->tva_number])
            ->andFilterWhere(['like', 'company.naf', $this->naf])
            ->andFilterWhere(['like', 'company.siren', $this->siren]);

        return $dataProvider;
    }
}
