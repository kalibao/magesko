<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\models\cmsSimpleMenu\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\cmsSimpleMenu\CmsSimpleMenu;

/**
 * This is the model filter class for controller "CmsSimpleMenu".
 *
 * @property integer $id
 * @property integer $position
 * @property string $cms_simple_menu_group_i18n_title
 * @property integer $cms_simple_menu_group_id
 * @property string $cms_simple_menu_i18n_title
 * @property string $cms_simple_menu_i18n_url
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\cms\models\cmsSimpleMenu\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends CmsSimpleMenu implements ModelFilterInterface
{
    public $cms_simple_menu_group_i18n_title;
    public $cms_simple_menu_i18n_title;
    public $cms_simple_menu_i18n_url;
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
                'id', 'position', 'cms_simple_menu_group_i18n_title', 'cms_simple_menu_group_id', 'cms_simple_menu_i18n_title', 'cms_simple_menu_i18n_url', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position', 'cms_simple_menu_group_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['cms_simple_menu_group_i18n_title', 'cms_simple_menu_i18n_title', 'cms_simple_menu_i18n_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['cms_simple_menu_i18n_title'] = Yii::t('kalibao','model:title');
        $attributeLabels['cms_simple_menu_i18n_url'] = Yii::t('kalibao','cms_simple_menu:url');
        $attributeLabels['cms_simple_menu_group_i18n_title'] = Yii::t('kalibao','cms_simple_menu:cms_simple_menu_group_id');

        return $attributeLabels;
    }


    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'cmsSimpleMenuGroupI18ns' => function ($query) use ($language) {
                $query->select(['cms_simple_menu_group_id', 'title'])->onCondition(['cms_simple_menu_group_i18n.i18n_id' => $language]);
            },
            'cmsSimpleMenuI18ns' => function ($query) use ($language) {
                $query->select(['cms_simple_menu_id', 'title', 'url'])->onCondition(['cms_simple_menu_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'position' => [
                        'label' => $this->getAttributeLabel('position')
                    ],
                    'cms_simple_menu_group_i18n_title' => [
                        'asc' => ['cms_simple_menu_group_i18n.title' => SORT_ASC],
                        'desc' => ['cms_simple_menu_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                    'cms_simple_menu_group_id',
                    'cms_simple_menu_i18n_title' => [
                        'asc' => ['cms_simple_menu_i18n.title' => SORT_ASC],
                        'desc' => ['cms_simple_menu_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_simple_menu_i18n_title')
                    ],
                    'cms_simple_menu_i18n_url' => [
                        'asc' => ['cms_simple_menu_i18n.url' => SORT_ASC],
                        'desc' => ['cms_simple_menu_i18n.url' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_simple_menu_i18n_url')
                    ],
                    'created_at',
                    'updated_at',
                ],
                'defaultOrder' => [
                    'position' => SORT_ASC
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

        $query->andFilterWhere(['>=', 'cms_simple_menu.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_simple_menu.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'cms_simple_menu.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_simple_menu.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['cms_simple_menu.id' => $this->id])
            ->andFilterWhere(['cms_simple_menu.position' => $this->position])
            ->andFilterWhere(['like', 'cms_simple_menu_group_i18n.title', $this->cms_simple_menu_group_i18n_title])
            ->andFilterWhere(['cms_simple_menu.cms_simple_menu_group_id' => $this->cms_simple_menu_group_id])
            ->andFilterWhere(['like', 'cms_simple_menu_i18n.title', $this->cms_simple_menu_i18n_title])
            ->andFilterWhere(['like', 'cms_simple_menu_i18n.url', $this->cms_simple_menu_i18n_url]);

        return $dataProvider;
    }
}
