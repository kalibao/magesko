<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\models\sheetType\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\sheetType\SheetType;

/**
 * This is the model filter class for controller "SheetType".
 *
 * @property integer $id
 * @property string $url_pick
 * @property string $table
 * @property string $url_zoom_front
 * @property string $url_zoom_back
 * @property string $sheet_type_i18n_label
 * @property string $created_at_start
 * @property string $created_at_end
 * @property string $updated_at_start
 * @property string $updated_at_end
 *
 * @package kalibao\backend\modules\tree\models\sheetType\crud
 * @version 1.0
 */
class ModelFilter extends SheetType implements ModelFilterInterface
{
    public $sheet_type_i18n_label;
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
                'id', 'url_pick', 'table', 'url_zoom_front', 'url_zoom_back', 'sheet_type_i18n_label', 'created_at_start', 'created_at_end', 'updated_at_start', 'updated_at_end'
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
            [['url_pick', 'url_zoom_front', 'url_zoom_back'], 'string', 'max' => 250],
            [['table'], 'string', 'max' => 64],
            [['sheet_type_i18n_label'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sheet_type_i18n_label' => Yii::t('kalibao.backend','sheet_type_i18n_label'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'sheetTypeI18ns' => function ($query) use ($language) {
                $query->select(['sheet_type_id', 'label'])->onCondition(['sheet_type_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'url_pick',
                    'table',
                    'url_zoom_front',
                    'url_zoom_back',
                    'sheet_type_i18n_label' => [
                        'asc' => ['sheet_type_i18n.label' => SORT_ASC],
                        'desc' => ['sheet_type_i18n.label' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('sheet_type_i18n_label')
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

        $query->andFilterWhere(['>=', 'sheet_type.created_at', $this->created_at_start]);
        if ($this->created_at_end != '') {
            $query->andWhere([
                '<=',
                'sheet_type.created_at',
                (new \DateTime($this->created_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
        $query->andFilterWhere(['>=', 'sheet_type.updated_at', $this->updated_at_start]);
        if ($this->updated_at_end != '') {
            $query->andWhere([
                '<=',
                'sheet_type.updated_at',
                (new \DateTime($this->updated_at_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }

        $query
            ->andFilterWhere(['sheet_type.id' => $this->id])
            ->andFilterWhere(['like', 'sheet_type.url_pick', $this->url_pick])
            ->andFilterWhere(['like', 'sheet_type.table', $this->table])
            ->andFilterWhere(['like', 'sheet_type.url_zoom_front', $this->url_zoom_front])
            ->andFilterWhere(['like', 'sheet_type.url_zoom_back', $this->url_zoom_back])
            ->andFilterWhere(['like', 'sheet_type_i18n.label', $this->sheet_type_i18n_label]);

        return $dataProvider;
    }
}
