<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\language\models\languageGroupLanguage\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\languageGroupLanguage\LanguageGroupLanguage;

/**
 * This is the model filter class for controller "LanguageGroupLanguage".
 *
 * @property integer $id
 * @property string $language_group_i18n_title
 * @property integer $language_group_id
 * @property string $language_i18n_title
 * @property string $language_id
 * @property integer $activated
 *
 * @package kalibao\backend\modules\languageGroup\models\languageGroupLanguage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends LanguageGroupLanguage implements ModelFilterInterface
{
    public $language_group_i18n_title;
    public $language_i18n_title;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id', 'activated', 'language_group_id', 'language_group_i18n_title', 'language_i18n_title', 'language_id'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language_group_id'], 'integer'],
            [['activated'], 'in', 'range' => [0, 1]],
            [['language_group_i18n_title', 'language_i18n_title'], 'string', 'max' => 255],
            [['language_id'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['language_i18n_title'] = Yii::t('kalibao','language_group_language:language_id');
        $attributeLabels['language_group_i18n_title'] = Yii::t('kalibao','language_group_language:language_group_id');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();

        $query->joinWith([
            'languageGroupI18ns' => function ($query) use ($language) {
                $query->select(['language_group_id', 'title'])->onCondition(['language_group_i18n.i18n_id' => $language]);
            },
            'languageI18ns' => function ($query) use ($language) {
                $query->select(['language_id', 'title'])->onCondition(['language_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'language_group_i18n_title' => [
                        'asc' => ['language_group_i18n.title' => SORT_ASC],
                        'desc' => ['language_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('language_group_i18n_title')
                    ],
                    'language_group_id',
                    'language_i18n_title' => [
                        'asc' => ['language_i18n.title' => SORT_ASC],
                        'desc' => ['language_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('language_i18n_title')
                    ],
                    'language_id',
                    'activated' => [
                        'label' => $this->getAttributeLabel('activated')
                    ],
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


        $query
            ->andFilterWhere(['language_group_language.id' => $this->id])
            ->andFilterWhere(['like', 'language_group_i18n.title', $this->language_group_i18n_title])
            ->andFilterWhere(['language_group_language.language_group_id' => $this->language_group_id])
            ->andFilterWhere(['like', 'language_i18n.title', $this->language_i18n_title])
            ->andFilterWhere(['like', 'language_group_language.language_id', $this->language_id])
            ->andFilterWhere(['language_group_language.activated' => $this->activated]);

        return $dataProvider;
    }
}
