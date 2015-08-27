<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\models\cmsPage\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\cmsPage\CmsPage;

/**
 * This is the model filter class for controller "CmsPage".
 *
 * @property integer $id
 * @property integer $activated
 * @property integer $cache_duration
 * @property string $cms_layout_i18n_name
 * @property integer $cms_layout_id
 * @property string $cms_page_i18n_title
 * @property string $cms_page_i18n_slug
 * @property string $cms_page_i18n_html_title
 * @property string $cms_page_i18n_html_description
 * @property string $cms_page_i18n_html_keywords
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\cms\models\cmsPage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends CmsPage implements ModelFilterInterface
{
    public $cms_layout_i18n_name;
    public $cms_page_i18n_title;
    public $cms_page_i18n_slug;
    public $cms_page_i18n_html_title;
    public $cms_page_i18n_html_description;
    public $cms_page_i18n_html_keywords;
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
                'id', 'activated', 'cache_duration', 'cms_layout_i18n_name', 'cms_layout_id',
                'cms_page_i18n_title', 'cms_page_i18n_slug', 'cms_page_i18n_html_title',
                'cms_page_i18n_html_description', 'cms_page_i18n_html_keywords', 'created_at_start',
                'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cache_duration', 'cms_layout_id'], 'integer'],
            [['activated'], 'in', 'range' => [0, 1]],
            [['cms_page_i18n_html_description', 'cms_page_i18n_html_keywords'], 'string'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['cms_layout_i18n_name'], 'string', 'max' => 100],
            [['cms_page_i18n_title', 'cms_page_i18n_slug', 'cms_page_i18n_html_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['cms_page_i18n_title'] = Yii::t('kalibao','model:title');
        $attributeLabels['cms_layout_i18n_name'] = Yii::t('kalibao', 'cms_page:cms_layout_id');
        $attributeLabels['cms_page_i18n_slug'] = Yii::t('kalibao','cms_page_i18n:slug');
        $attributeLabels['cms_page_i18n_html_title'] = Yii::t('kalibao','cms_page_i18n:html_title');
        $attributeLabels['cms_page_i18n_html_description'] = Yii::t('kalibao','cms_page_i18n:html_description');
        $attributeLabels['cms_page_i18n_html_keywords'] = Yii::t('kalibao','cms_page_i18n:html_keywords');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'cmsLayoutI18ns' => function ($query) use ($language) {
                $query->select(['cms_layout_id', 'name'])->onCondition(['cms_layout_i18n.i18n_id' => $language]);
            },
            'cmsPageI18ns' => function ($query) use ($language) {
                $query->select(['cms_page_id', 'title', 'slug', 'html_title', 'html_description', 'html_keywords'])->onCondition(['cms_page_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'activated' => [
                        'label' => $this->getAttributeLabel('activated')
                    ],
                    'cache_duration' => [
                        'label' => $this->getAttributeLabel('cache_duration')
                    ],
                    'cms_layout_i18n_name' => [
                        'asc' => ['cms_layout_i18n.name' => SORT_ASC],
                        'desc' => ['cms_layout_i18n.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_layout_i18n_name')
                    ],
                    'cms_layout_id',
                    'cms_page_i18n_title' => [
                        'asc' => ['cms_page_i18n.title' => SORT_ASC],
                        'desc' => ['cms_page_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_page_i18n_title')
                    ],
                    'cms_page_i18n_slug' => [
                        'asc' => ['cms_page_i18n.slug' => SORT_ASC],
                        'desc' => ['cms_page_i18n.slug' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_page_i18n_slug')
                    ],
                    'cms_page_i18n_html_title' => [
                        'asc' => ['cms_page_i18n.html_title' => SORT_ASC],
                        'desc' => ['cms_page_i18n.html_title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_page_i18n_html_title')
                    ],
                    'cms_page_i18n_html_description' => [
                        'asc' => ['cms_page_i18n.html_description' => SORT_ASC],
                        'desc' => ['cms_page_i18n.html_description' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_page_i18n_html_description')
                    ],
                    'cms_page_i18n_html_keywords' => [
                        'asc' => ['cms_page_i18n.html_keywords' => SORT_ASC],
                        'desc' => ['cms_page_i18n.html_keywords' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_page_i18n_html_keywords')
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

        $query->andFilterWhere(['>=', 'cms_page.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_page.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'cms_page.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_page.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['cms_page.id' => $this->id])
            ->andFilterWhere(['cms_page.activated' => $this->activated])
            ->andFilterWhere(['cms_page.cache_duration' => $this->cache_duration])
            ->andFilterWhere(['like', 'cms_layout_i18n.name', $this->cms_layout_i18n_name])
            ->andFilterWhere(['cms_page.cms_layout_id' => $this->cms_layout_id])
            ->andFilterWhere(['like', 'cms_page_i18n.title', $this->cms_page_i18n_title])
            ->andFilterWhere(['like', 'cms_page_i18n.slug', $this->cms_page_i18n_slug])
            ->andFilterWhere(['like', 'cms_page_i18n.html_title', $this->cms_page_i18n_html_title])
            ->andFilterWhere(['like', 'cms_page_i18n.html_description', $this->cms_page_i18n_html_description])
            ->andFilterWhere(['like', 'cms_page_i18n.html_keywords', $this->cms_page_i18n_html_keywords]);

        return $dataProvider;
    }
}
