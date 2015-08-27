<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\models\personGender\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\person\PersonGender;

/**
 * This is the model filter class for controller "PersonGender".
 *
 * @property integer $id
 * @property integer $person_gender_i18n_gender_id
 * @property string $person_gender_i18n_title
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\third\models\personGender\crud
 * @version 1.0
 */
class ModelFilter extends PersonGender implements ModelFilterInterface
{
    public $person_gender_i18n_gender_id;
    public $person_gender_i18n_title;
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
                'id', 'person_gender_i18n_gender_id', 'person_gender_i18n_title', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'person_gender_i18n_gender_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['person_gender_i18n_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'person_gender_i18n_gender_id' => Yii::t('kalibao.backend','person_gender_i18n_gender_id'),
            'person_gender_i18n_title' => Yii::t('kalibao.backend','person_gender_i18n_title'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'personGenderI18ns' => function ($query) use ($language) {
                $query->select(['gender_id', 'gender_id', 'title'])->onCondition(['person_gender_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'person_gender_i18n_gender_id' => [
                        'asc' => ['person_gender_i18n.gender_id' => SORT_ASC],
                        'desc' => ['person_gender_i18n.gender_id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('person_gender_i18n_gender_id')
                    ],
                    'person_gender_i18n_title' => [
                        'asc' => ['person_gender_i18n.title' => SORT_ASC],
                        'desc' => ['person_gender_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('person_gender_i18n_title')
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

        $query->andFilterWhere(['>=', 'person_gender.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'person_gender.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'person_gender.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'person_gender.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['person_gender.id' => $this->id])
            ->andFilterWhere(['person_gender_i18n.gender_id' => $this->person_gender_i18n_gender_id])
            ->andFilterWhere(['like', 'person_gender_i18n.title', $this->person_gender_i18n_title]);

        return $dataProvider;
    }
}
