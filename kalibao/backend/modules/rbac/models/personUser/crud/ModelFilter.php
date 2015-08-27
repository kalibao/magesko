<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\rbac\models\personUser\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\person\Person;
use kalibao\common\models\user\User;

/**
 * This is the model filter class for controller "PersonUser".
 *
 * @property integer $third_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $language_i18n_title
 * @property string $default_language
 * @property integer $user_status
 * @property integer $user_active_password_reset
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\rbac\models\person\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends Person implements ModelFilterInterface
{
    public $language_i18n_title;
    public $user_status;
    public $user_active_password_reset;
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
                'third_id', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end',
                'user_status', 'user_active_password_reset', 'first_name', 'last_name', 'email',
                'language_i18n_title', 'default_language'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['third_id', 'user_status', 'user_active_password_reset'], 'integer'],
            ['user_status', 'in', 'range' => [User::STATUS_ENABLED, User::STATUS_DISABLED]],
            ['user_active_password_reset', 'in', 'range' => [0, 1]],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['email', 'language_i18n_title'], 'string', 'max' => 255],
            [['default_language'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['language_i18n_title'] = Yii::t('kalibao','person:default_language');
        $attributeLabels['user_status'] = Yii::t('kalibao','user:status');
        $attributeLabels['user_active_password_reset'] = Yii::t('kalibao','user:active_password_reset');
        return $attributeLabels;
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
                $query->select(['id', 'status', 'active_password_reset']);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'third_id',
                    'first_name' => [
                        'label' => $this->getAttributeLabel('first_name')
                    ],
                    'last_name' => [
                        'label' => $this->getAttributeLabel('last_name')
                    ],
                    'email' => [
                        'label' => $this->getAttributeLabel('email')
                    ],
                    'language_i18n_title' => [
                        'asc' => ['language_i18n.title' => SORT_ASC],
                        'desc' => ['language_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('language_i18n_title')
                    ],
                    'default_language',
                    'user_status' => [
                        'asc' => ['user.status' => SORT_ASC],
                        'desc' => ['user.status' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('user_status')
                    ],
                    'user_active_password_reset' => [
                        'asc' => ['user.active_password_reset' => SORT_ASC],
                        'desc' => ['user.active_password_reset' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('user_active_password_reset')
                    ],
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
            ->andFilterWhere(['user.status' => $this->user_status])
            ->andFilterWhere(['user.active_password_reset' => $this->user_active_password_reset]);

        return $dataProvider;
    }
}
