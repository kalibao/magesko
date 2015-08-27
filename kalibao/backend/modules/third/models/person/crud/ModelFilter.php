<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\models\person\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\person\Person;

/**
 * This is the model filter class for controller "Person".
 *
 * @property integer $third_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $language_i18n_title
 * @property string $default_language
 * @property string $user_username
 * @property integer $user_id
 * @property string $person_gender_i18n_title
 * @property integer $gender_id
 * @property string $phone_1
 * @property string $phone_2
 * @property string $fax
 * @property string $website
 * @property string $birthday
 * @property string $skype
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\third\models\person\crud
 * @version 1.0
 */
class ModelFilter extends Person implements ModelFilterInterface
{
    public $language_i18n_title;
    public $user_username;
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
                'third_id', 'first_name', 'last_name', 'email', 'language_i18n_title', 'default_language', 'user_username', 'user_id', 'person_gender_i18n_title', 'gender_id', 'phone_1', 'phone_2', 'fax', 'website', 'birthday', 'skype', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['third_id', 'user_id', 'gender_id'], 'integer'],
            [['birthday'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['email', 'language_i18n_title', 'user_username', 'person_gender_i18n_title'], 'string', 'max' => 255],
            [['default_language'], 'string', 'max' => 16],
            [['phone_1', 'phone_2', 'fax', 'website', 'skype'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'language_i18n_title' => Yii::t('kalibao.backend','language_i18n_title'),
            'user_username' => Yii::t('kalibao.backend','user_username'),
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
            'languageI18ns' => function ($query) use ($language) {
                $query->select(['language_id', 'title'])->onCondition(['language_i18n.i18n_id' => $language]);
            },
            'user' => function ($query) use ($language) {
                $query->select(['id', 'username']);
            },
            'personGenderI18ns' => function ($query) use ($language) {
                $query->select(['gender_id', 'title'])->onCondition(['person_gender_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'third_id',
                    'first_name',
                    'last_name',
                    'email',
                    'language_i18n_title' => [
                        'asc' => ['language_i18n.title' => SORT_ASC],
                        'desc' => ['language_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('language_i18n_title')
                    ],
                    'default_language',
                    'user_username' => [
                        'asc' => ['user.username' => SORT_ASC],
                        'desc' => ['user.username' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('user_username')
                    ],
                    'user_id',
                    'person_gender_i18n_title' => [
                        'asc' => ['person_gender_i18n.title' => SORT_ASC],
                        'desc' => ['person_gender_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('person_gender_i18n_title')
                    ],
                    'gender_id',
                    'phone_1',
                    'phone_2',
                    'fax',
                    'website',
                    'birthday',
                    'skype',
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

        $query->andFilterWhere(['>=', 'person.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'person.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'person.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'person.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['person.third_id' => $this->third_id])
            ->andFilterWhere(['like', 'person.first_name', $this->first_name])
            ->andFilterWhere(['like', 'person.last_name', $this->last_name])
            ->andFilterWhere(['like', 'person.email', $this->email])
            ->andFilterWhere(['like', 'language_i18n.title', $this->language_i18n_title])
            ->andFilterWhere(['like', 'person.default_language', $this->default_language])
            ->andFilterWhere(['like', 'user.username', $this->user_username])
            ->andFilterWhere(['person.user_id' => $this->user_id])
            ->andFilterWhere(['like', 'person_gender_i18n.title', $this->person_gender_i18n_title])
            ->andFilterWhere(['person.gender_id' => $this->gender_id])
            ->andFilterWhere(['like', 'person.phone_1', $this->phone_1])
            ->andFilterWhere(['like', 'person.phone_2', $this->phone_2])
            ->andFilterWhere(['like', 'person.fax', $this->fax])
            ->andFilterWhere(['like', 'person.website', $this->website])
            ->andFilterWhere(['person.birthday' => $this->birthday])
            ->andFilterWhere(['like', 'person.skype', $this->skype]);

        return $dataProvider;
    }
}
