<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\models\cmsNews\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\cmsNews\CmsNews;

/**
 * This is the model filter class for controller "CmsNews".
 *
 * @property integer $id
 * @property string $cms_news_group_i18n_title
 * @property integer $cms_news_group_id
 * @property integer $activated
 * @property string $published_at
 * @property string $cms_news_i18n_title
 * @property string $cms_news_i18n_content
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\cms\models\cmsNews\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends CmsNews implements ModelFilterInterface
{
    public $cms_news_group_i18n_title;
    public $cms_news_i18n_title;
    public $cms_news_i18n_content;
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
                'id', 'cms_news_group_i18n_title', 'cms_news_group_id', 'activated', 'published_at', 'cms_news_i18n_title', 'cms_news_i18n_content', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cms_news_group_id'], 'integer'],
            [['activated'], 'in', 'range' => [0, 1]],
            [['published_at'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['cms_news_i18n_content'], 'string'],
            [['cms_news_group_i18n_title', 'cms_news_i18n_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['cms_news_i18n_title'] = Yii::t('kalibao','model:title');
        $attributeLabels['cms_news_group_i18n_title'] = Yii::t('kalibao','cms_news:cms_news_group_id');
        $attributeLabels['cms_news_i18n_content'] = Yii::t('kalibao','cms_news_i18n:content');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'cmsNewsGroupI18ns' => function ($query) use ($language) {
                $query->select(['cms_news_group_id', 'title'])->onCondition(['cms_news_group_i18n.i18n_id' => $language]);
            },
            'cmsNewsI18ns' => function ($query) use ($language) {
                $query->select(['cms_news_id', 'title', 'content'])->onCondition(['cms_news_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'cms_news_group_i18n_title' => [
                        'asc' => ['cms_news_group_i18n.title' => SORT_ASC],
                        'desc' => ['cms_news_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_news_group_i18n_title')
                    ],
                    'cms_news_group_id',
                    'activated' => [
                        'label' => $this->getAttributeLabel('activated')
                    ],
                    'published_at' => [
                        'label' => $this->getAttributeLabel('published_at')
                    ],
                    'cms_news_i18n_title' => [
                        'asc' => ['cms_news_i18n.title' => SORT_ASC],
                        'desc' => ['cms_news_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_news_i18n_title')
                    ],
                    'cms_news_i18n_content' => [
                        'asc' => ['cms_news_i18n.content' => SORT_ASC],
                        'desc' => ['cms_news_i18n.content' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_news_i18n_content')
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

        $query->andFilterWhere(['>=', 'cms_news.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_news.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'cms_news.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_news.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['cms_news.id' => $this->id])
            ->andFilterWhere(['like', 'cms_news_group_i18n.title', $this->cms_news_group_i18n_title])
            ->andFilterWhere(['cms_news.cms_news_group_id' => $this->cms_news_group_id])
            ->andFilterWhere(['cms_news.activated' => $this->activated])
            ->andFilterWhere(['cms_news.published_at' => $this->published_at])
            ->andFilterWhere(['like', 'cms_news_i18n.title', $this->cms_news_i18n_title])
            ->andFilterWhere(['like', 'cms_news_i18n.content', $this->cms_news_i18n_content]);

        return $dataProvider;
    }
}
