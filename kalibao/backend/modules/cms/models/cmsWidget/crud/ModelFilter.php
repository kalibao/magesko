<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\models\cmsWidget\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\cmsWidget\CmsWidget;

/**
 * This is the model filter class for controller "CmsWidget".
 *
 * @property integer $id
 * @property string $path
 * @property string $arg
 * @property string $cms_widget_group_i18n_title
 * @property integer $cms_widget_group_id
 * @property string $cms_widget_i18n_title
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\cms\models\cmsWidget\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends CmsWidget implements ModelFilterInterface
{
    public $cms_widget_group_i18n_title;
    public $cms_widget_i18n_title;
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
                'id', 'path', 'arg', 'cms_widget_group_i18n_title', 'cms_widget_group_id', 'cms_widget_i18n_title', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cms_widget_group_id'], 'integer'],
            [['arg'], 'string'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['path'], 'string', 'max' => 255],
            [['cms_widget_group_i18n_title', 'cms_widget_i18n_title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['cms_widget_i18n_title'] = Yii::t('kalibao','model:title');
        $attributeLabels['cms_widget_group_i18n_title'] = Yii::t('kalibao','cms_widget:cms_widget_group_id');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'cmsWidgetGroupI18ns' => function ($query) use ($language) {
                $query->select(['cms_widget_group_id', 'title'])->onCondition(['cms_widget_group_i18n.i18n_id' => $language]);
            },
            'cmsWidgetI18ns' => function ($query) use ($language) {
                $query->select(['cms_widget_id', 'title'])->onCondition(['cms_widget_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'path',
                    'arg',
                    'cms_widget_group_i18n_title' => [
                        'asc' => ['cms_widget_group_i18n.title' => SORT_ASC],
                        'desc' => ['cms_widget_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_widget_group_i18n_title')
                    ],
                    'cms_widget_group_id',
                    'cms_widget_i18n_title' => [
                        'asc' => ['cms_widget_i18n.title' => SORT_ASC],
                        'desc' => ['cms_widget_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_widget_i18n_title')
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

        $query->andFilterWhere(['>=', 'cms_widget.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_widget.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'cms_widget.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_widget.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['cms_widget.id' => $this->id])
            ->andFilterWhere(['like', 'cms_widget.path', $this->path])
            ->andFilterWhere(['like', 'cms_widget.arg', $this->arg])
            ->andFilterWhere(['like', 'cms_widget_group_i18n.title', $this->cms_widget_group_i18n_title])
            ->andFilterWhere(['cms_widget.cms_widget_group_id' => $this->cms_widget_group_id])
            ->andFilterWhere(['like', 'cms_widget_i18n.title', $this->cms_widget_i18n_title]);

        return $dataProvider;
    }
}
