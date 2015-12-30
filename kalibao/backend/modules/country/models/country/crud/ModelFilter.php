<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\country\models\country\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\country\Country;

/**
 * This is the model filter class for controller "Country".
 *
 * @property string $id
 * @property string $iso3
 * @property integer $numcode
 * @property integer $phonecode
 * @property string $country_i18n_name
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\country\models\country\crud
 * @version 1.0
 */
class ModelFilter extends Country implements ModelFilterInterface
{
    public $country_i18n_name;
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
                'id', 'iso3', 'numcode', 'phonecode', 'country_i18n_name', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numcode', 'phonecode'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['id'], 'string', 'max' => 2],
            [['iso3'], 'string', 'max' => 3],
            [['country_i18n_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_i18n_name' => Yii::t('kalibao.backend','country_i18n_name'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'countryI18ns' => function ($query) use ($language) {
                $query->select(['country_id', 'name'])->onCondition(['country_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'iso3',
                    'numcode',
                    'phonecode',
                    'country_i18n_name' => [
                        'asc' => ['country_i18n.name' => SORT_ASC],
                        'desc' => ['country_i18n.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('country_i18n_name')
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

        $query->andFilterWhere(['>=', 'country.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'country.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'country.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'country.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['like', 'country.id', $this->id])
            ->andFilterWhere(['like', 'country.iso3', $this->iso3])
            ->andFilterWhere(['country.numcode' => $this->numcode])
            ->andFilterWhere(['country.phonecode' => $this->phonecode])
            ->andFilterWhere(['like', 'country_i18n.name', $this->country_i18n_name]);

        return $dataProvider;
    }
}
