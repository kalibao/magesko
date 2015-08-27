<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\models\address\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\address\Address;

/**
 * This is the model filter class for controller "Address".
 *
 * @property integer $id
 * @property integer $third_id
 * @property string $address_type_i18n_title
 * @property integer $address_type_id
 * @property string $label
 * @property string $place_1
 * @property string $place_2
 * @property string $street_number
 * @property string $door_code
 * @property string $zip_code
 * @property string $city
 * @property string $country
 * @property integer $is_primary
 * @property string $note
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\third\models\address\crud
 * @version 1.0
 */
class ModelFilter extends Address implements ModelFilterInterface
{
    public $address_type_i18n_title;
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
                'id', 'third_id', 'address_type_i18n_title', 'address_type_id', 'label', 'place_1', 'place_2', 'street_number', 'door_code', 'zip_code', 'city', 'country', 'is_primary', 'note', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'third_id', 'address_type_id'], 'integer'],
            [['is_primary'], 'in', 'range' => [0, 1]],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['address_type_i18n_title', 'note'], 'string', 'max' => 255],
            [['label', 'place_1', 'place_2', 'street_number', 'door_code', 'zip_code', 'city', 'country'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_type_i18n_title' => Yii::t('kalibao.backend','address_type_i18n_title'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'addressTypeI18ns' => function ($query) use ($language) {
                $query->select(['address_type_id', 'title'])->onCondition(['address_type_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'third_id',
                    'address_type_i18n_title' => [
                        'asc' => ['address_type_i18n.title' => SORT_ASC],
                        'desc' => ['address_type_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('address_type_i18n_title')
                    ],
                    'address_type_id',
                    'label',
                    'place_1',
                    'place_2',
                    'street_number',
                    'door_code',
                    'zip_code',
                    'city',
                    'country',
                    'is_primary',
                    'note',
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

        $query->andFilterWhere(['>=', 'address.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'address.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'address.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'address.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['address.id' => $this->id])
            ->andFilterWhere(['address.third_id' => $this->third_id])
            ->andFilterWhere(['like', 'address_type_i18n.title', $this->address_type_i18n_title])
            ->andFilterWhere(['address.address_type_id' => $this->address_type_id])
            ->andFilterWhere(['like', 'address.label', $this->label])
            ->andFilterWhere(['like', 'address.place_1', $this->place_1])
            ->andFilterWhere(['like', 'address.place_2', $this->place_2])
            ->andFilterWhere(['like', 'address.street_number', $this->street_number])
            ->andFilterWhere(['like', 'address.door_code', $this->door_code])
            ->andFilterWhere(['like', 'address.zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'address.city', $this->city])
            ->andFilterWhere(['like', 'address.country', $this->country])
            ->andFilterWhere(['address.is_primary' => $this->is_primary])
            ->andFilterWhere(['like', 'address.note', $this->note]);

        return $dataProvider;
    }
}
