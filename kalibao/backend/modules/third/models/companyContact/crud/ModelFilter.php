<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\models\companyContact\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\company\CompanyContact;

/**
 * This is the model filter class for controller "CompanyContact".
 *
 * @property string $company_name
 * @property integer $company_id
 * @property string $person_last_name
 * @property integer $person_id
 * @property integer $is_primary
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\third\models\companyContact\crud
 * @version 1.0
 */
class ModelFilter extends CompanyContact implements ModelFilterInterface
{
    public $company_name;
    public $person_last_name;
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
                'company_name', 'company_id', 'person_last_name', 'person_id', 'is_primary', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'person_id'], 'integer'],
            [['is_primary'], 'in', 'range' => [0, 1]],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['company_name'], 'string', 'max' => 45],
            [['person_last_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_name' => Yii::t('kalibao.backend','company_name'),
            'person_last_name' => Yii::t('kalibao.backend','person_last_name'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'company' => function ($query) use ($language) {
                $query->select(['third_id', 'name']);
            },
            'person' => function ($query) use ($language) {
                $query->select(['third_id', 'last_name']);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'company_name' => [
                        'asc' => ['company.name' => SORT_ASC],
                        'desc' => ['company.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('company_name')
                    ],
                    'company_id',
                    'person_last_name' => [
                        'asc' => ['person.last_name' => SORT_ASC],
                        'desc' => ['person.last_name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('person_last_name')
                    ],
                    'person_id',
                    'is_primary',
                    'created_at',
                    'updated_at',
                ],
                'defaultOrder' => [
                    'company_id' => SORT_DESC
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

        $query->andFilterWhere(['>=', 'company_contact.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'company_contact.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'company_contact.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'company_contact.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['like', 'company.name', $this->company_name])
            ->andFilterWhere(['company_contact.company_id' => $this->company_id])
            ->andFilterWhere(['like', 'person.last_name', $this->person_last_name])
            ->andFilterWhere(['company_contact.person_id' => $this->person_id])
            ->andFilterWhere(['company_contact.is_primary' => $this->is_primary]);

        return $dataProvider;
    }
}
