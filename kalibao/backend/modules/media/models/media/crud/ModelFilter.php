<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\media\models\media\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\media\Media;

/**
 * This is the model filter class for controller "Media".
 *
 * @property integer $id
 * @property string $file
 * @property string $media_type_i18n_title
 * @property integer $media_type_id
 * @property string $media_i18n_title
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\media\models\media\crud
 * @version 1.0
 */
class ModelFilter extends Media implements ModelFilterInterface
{
    public $media_type_i18n_title;
    public $media_i18n_title;
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
                'id', 'file', 'media_type_i18n_title', 'media_type_id', 'media_i18n_title', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'media_type_id'], 'integer'],
            [['created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'], 'date', 'format' => 'yyyy-MM-dd'],
            [['file', 'media_type_i18n_title', 'media_i18n_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'media_type_i18n_title' => Yii::t('kalibao.backend','media_type_i18n_title'),
            'media_i18n_title' => Yii::t('kalibao.backend','media_i18n_title'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'mediaTypeI18ns' => function ($query) use ($language) {
                $query->select(['media_type_id', 'title'])->onCondition(['media_type_i18n.i18n_id' => $language]);
            },
            'mediaI18ns' => function ($query) use ($language) {
                $query->select(['media_id', 'title'])->onCondition(['media_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'file',
                    'media_type_i18n_title' => [
                        'asc' => ['media_type_i18n.title' => SORT_ASC],
                        'desc' => ['media_type_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('media_type_i18n_title')
                    ],
                    'media_type_id',
                    'media_i18n_title' => [
                        'asc' => ['media_i18n.title' => SORT_ASC],
                        'desc' => ['media_i18n.title' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('media_i18n_title')
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

        $query->andFilterWhere(['>=', 'media.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'media.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'media.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'media.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['media.id' => $this->id])
            ->andFilterWhere(['like', 'media.file', $this->file])
            ->andFilterWhere(['like', 'media_type_i18n.title', $this->media_type_i18n_title])
            ->andFilterWhere(['media.media_type_id' => $this->media_type_id])
            ->andFilterWhere(['like', 'media_i18n.title', $this->media_i18n_title]);

        return $dataProvider;
    }
}
