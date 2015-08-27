<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\models\cmsLayout\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\cmsLayout\CmsLayout;

/**
 * This is the model filter class for controller "CmsLayout".
 *
 * @property integer $id
 * @property integer $max_container
 * @property string $path
 * @property string $view
 * @property string $cms_layout_i18n_name
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\cms\models\cmsLayout\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends CmsLayout implements ModelFilterInterface
{
    public $cms_layout_i18n_name;
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
                'id', 'max_container', 'path', 'view', 'cms_layout_i18n_name', 'created_at_start',
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
            [['id', 'max_container'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['path', 'view'], 'string', 'max' => 255],
            [['cms_layout_i18n_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['cms_layout_i18n_name'] = Yii::t('kalibao','model:title');
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
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'max_container' => [
                        'label' => $this->getAttributeLabel('max_container')
                    ],
                    'path' => [
                        'label' => $this->getAttributeLabel('path')
                    ],
                    'view' => [
                        'label' => $this->getAttributeLabel('view')
                    ],
                    'cms_layout_i18n_name' => [
                        'asc' => ['cms_layout_i18n.name' => SORT_ASC],
                        'desc' => ['cms_layout_i18n.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_layout_i18n_name')
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

        $query->andFilterWhere(['>=', 'cms_layout.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_layout.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'cms_layout.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_layout.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['cms_layout.id' => $this->id])
            ->andFilterWhere(['cms_layout.max_container' => $this->max_container])
            ->andFilterWhere(['like', 'cms_layout.path', $this->path])
            ->andFilterWhere(['like', 'cms_layout.view', $this->view])
            ->andFilterWhere(['like', 'cms_layout_i18n.name', $this->cms_layout_i18n_name]);

        return $dataProvider;
    }
}
