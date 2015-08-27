<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\logisticStrategy\models\logisticStrategy\crud;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
use kalibao\common\models\logisticStrategy\LogisticStrategy;

/**
 * This is the model filter class for controller "LogisticStrategy".
 *
 * @property integer $id
 * @property integer $stockout
 * @property integer $preorder
 * @property string $delivery_date
 * @property integer $real_stock
 * @property integer $alert_stock
 * @property integer $direct_delivery
 * @property string $supplier_name
 * @property integer $supplier_id
 * @property integer $additional_delay
 * @property integer $just_in_time
 * @property integer $temporary_stockout
 * @property string $logistic_strategy_i18n_message
 *
 * @package kalibao\backend\modules\logisticStrategy\models\logisticStrategy\crud
 * @version 1.0
 */
class ModelFilter extends LogisticStrategy implements ModelFilterInterface
{
    public $supplier_name;
    public $logistic_strategy_i18n_message;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id', 'stockout', 'preorder', 'delivery_date', 'real_stock', 'alert_stock', 'direct_delivery', 'supplier_name', 'supplier_id', 'additional_delay', 'just_in_time', 'temporary_stockout', 'logistic_strategy_i18n_message'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'alert_stock', 'supplier_id', 'additional_delay'], 'integer'],
            [['stockout', 'preorder', 'real_stock', 'direct_delivery', 'just_in_time', 'temporary_stockout'], 'in', 'range' => [0, 1]],
            [['delivery_date'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['supplier_name'], 'string', 'max' => 255],
            [['logistic_strategy_i18n_message'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplier_name' => Yii::t('kalibao.backend','supplier_name'),
            'logistic_strategy_i18n_message' => Yii::t('kalibao.backend','logistic_strategy_i18n_message'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
        $query->joinWith([
            'supplier' => function ($query) use ($language) {
                $query->select(['id', 'name']);
            },
            'logisticStrategyI18ns' => function ($query) use ($language) {
                $query->select(['logistic_strategy_id', 'message'])->onCondition(['logistic_strategy_i18n.i18n_id' => $language]);
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'stockout',
                    'preorder',
                    'delivery_date',
                    'real_stock',
                    'alert_stock',
                    'direct_delivery',
                    'supplier_name' => [
                        'asc' => ['supplier.name' => SORT_ASC],
                        'desc' => ['supplier.name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('supplier_name')
                    ],
                    'supplier_id',
                    'additional_delay',
                    'just_in_time',
                    'temporary_stockout',
                    'logistic_strategy_i18n_message' => [
                        'asc' => ['logistic_strategy_i18n.message' => SORT_ASC],
                        'desc' => ['logistic_strategy_i18n.message' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('logistic_strategy_i18n_message')
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
            ->andFilterWhere(['logistic_strategy.id' => $this->id])
            ->andFilterWhere(['logistic_strategy.stockout' => $this->stockout])
            ->andFilterWhere(['logistic_strategy.preorder' => $this->preorder])
            ->andFilterWhere(['logistic_strategy.delivery_date' => $this->delivery_date])
            ->andFilterWhere(['logistic_strategy.real_stock' => $this->real_stock])
            ->andFilterWhere(['logistic_strategy.alert_stock' => $this->alert_stock])
            ->andFilterWhere(['logistic_strategy.direct_delivery' => $this->direct_delivery])
            ->andFilterWhere(['like', 'supplier.name', $this->supplier_name])
            ->andFilterWhere(['logistic_strategy.supplier_id' => $this->supplier_id])
            ->andFilterWhere(['logistic_strategy.additional_delay' => $this->additional_delay])
            ->andFilterWhere(['logistic_strategy.just_in_time' => $this->just_in_time])
            ->andFilterWhere(['logistic_strategy.temporary_stockout' => $this->temporary_stockout])
            ->andFilterWhere(['like', 'logistic_strategy_i18n.message', $this->logistic_strategy_i18n_message]);

        return $dataProvider;
    }
}
