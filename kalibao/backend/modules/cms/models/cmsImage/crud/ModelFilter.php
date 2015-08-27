<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\models\cmsImage\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\cmsImage\CmsImage;

/**
 * This is the model filter class for controller "CmsImage".
 *
 * @property integer $id
 * @property string $file_path
 * @property string $cms_image_group_i18n_title
 * @property integer $cms_image_group_id
 * @property string $cms_image_i18n_title
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\common\models\cmsImage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ModelFilter extends CmsImage implements ModelFilterInterface
{
    public $cms_image_group_i18n_title;
    public $cms_image_i18n_title;
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
                'id', 'file_path', 'cms_image_group_i18n_title', 'cms_image_group_id',
                'cms_image_i18n_title', 'created_at_start', 'created_at_end', 'updated_at_start',
                'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cms_image_group_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['file_path', 'cms_image_group_i18n_title', 'cms_image_i18n_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['cms_image_group_i18n_title'] = Yii::t('kalibao','cms_image:cms_image_group_id');
        $attributeLabels['cms_image_i18n_title'] = Yii::t('kalibao','model:title');
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'cmsImageGroupI18ns' => function ($query) use ($language) {
                $query->select(['cms_image_group_id', 'title'])->onCondition(['cms_image_group_i18n.i18n_id' => $language]);
            },
            'cmsImageI18ns' => function ($query) use ($language) {
                $query->select(['cms_image_id', 'title'])->onCondition(['cms_image_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'file_path' => [
                        'label' => $this->getAttributeLabel('file_path')
                    ],
                    'cms_image_group_i18n_title' => [
                        'asc' => ['cms_image_group_i18n.title' => SORT_ASC],
                        'desc' => ['cms_image_group_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_image_group_i18n_title')
                    ],
                    'cms_image_group_id',
                    'cms_image_i18n_title' => [
                        'asc' => ['cms_image_i18n.title' => SORT_ASC],
                        'desc' => ['cms_image_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('cms_image_i18n_title')
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

        $query->andFilterWhere(['>=', 'cms_image.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_image.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'cms_image.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'cms_image.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['cms_image.id' => $this->id])
            ->andFilterWhere(['like', 'cms_image.file_path', $this->file_path])
            ->andFilterWhere(['like', 'cms_image_group_i18n.title', $this->cms_image_group_i18n_title])
            ->andFilterWhere(['cms_image.cms_image_group_id' => $this->cms_image_group_id])
            ->andFilterWhere(['like', 'cms_image_i18n.title', $this->cms_image_i18n_title]);

        return $dataProvider;
    }
}
