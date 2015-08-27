<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\language\models\languageGroup\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\languageGroup\LanguageGroup;

/**
 * This is the model filter class for controller "LanguageGroup".
 *
 * @property integer $id
 * @property string $language_group_i18n_title
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\language\models\languageGroup\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends LanguageGroup implements ModelFilterInterface
{
    public $language_group_i18n_title;
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
                'id', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end',
                'language_group_i18n_title'
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
            [['language_group_i18n_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['language_group_i18n_title'] = Yii::t('kalibao','model:title');
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

        $query->andFilterWhere(['>=', 'language_group.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'language_group.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'language_group.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'language_group.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['language_group.id' => $this->id])
            ->andFilterWhere(['like', 'language_group_i18n.title', $this->language_group_i18n_title]);

        return $dataProvider;
    }
}
