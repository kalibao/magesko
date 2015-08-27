<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\logisticStrategy;

use kalibao\common\components\helpers\Date;
use Yii;
use kalibao\common\models\supplier\Supplier;
use kalibao\common\models\logisticStrategy\LogisticStrategyI18n;
use kalibao\common\models\variant\Variant;

/**
 * This is the model class for table "logistic_strategy".
 *
 * @property integer $id
 * @property integer $stockout
 * @property integer $preorder
 * @property string  $delivery_date
 * @property integer $real_stock
 * @property integer $alert_stock
 * @property integer $direct_delivery
 * @property integer $supplier_id
 * @property integer $additional_delay
 * @property integer $just_in_time
 * @property integer $temporary_stockout
 *
 * @property Supplier $supplier
 * @property LogisticStrategyI18n[] $logisticStrategyI18ns
 * @property Variant[] $variants
 *
 * @package kalibao\common\models\logisticStrategy
 * @version 1.0
 */
class LogisticStrategy extends \yii\db\ActiveRecord
{
    const STOCKOUT           = 1;
    const PREORDER           = 2;
    const REAL_STOCK         = 3;
    const DIRECT_DELIVERY    = 4;
    const JUST_IN_TIME       = 5;
    const TEMPORARY_STOCKOUT = 6;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logistic_strategy';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'stockout', 'preorder', 'delivery_date', 'real_stock', 'alert_stock', 'direct_delivery', 'supplier_id', 'additional_delay', 'just_in_time', 'temporary_stockout'
            ],
            'update' => [
                'stockout', 'preorder', 'delivery_date', 'real_stock', 'alert_stock', 'direct_delivery', 'supplier_id', 'additional_delay', 'just_in_time', 'temporary_stockout'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stockout', 'preorder', 'real_stock', 'direct_delivery', 'just_in_time', 'temporary_stockout'], 'in', 'range' => [0, 1]],
            [['delivery_date'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['alert_stock', 'supplier_id', 'additional_delay'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','label_logistic_strategy_id'),
            'stockout' => Yii::t('kalibao.backend','label_logistic_strategy_stockout'),
            'preorder' => Yii::t('kalibao.backend','label_logistic_strategy_preorder'),
            'delivery_date' => Yii::t('kalibao.backend','label_logistic_strategy_delivery_date'),
            'real_stock' => Yii::t('kalibao.backend','label_logistic_strategy_real_stock'),
            'alert_stock' => Yii::t('kalibao.backend','label_logistic_strategy_alert_stock'),
            'direct_delivery' => Yii::t('kalibao.backend','label_logistic_strategy_direct_delivery'),
            'supplier_id' => Yii::t('kalibao.backend','label_logistic_strategy_supplier_id'),
            'additional_delay' => Yii::t('kalibao.backend','label_logistic_strategy_additional_delay'),
            'just_in_time' => Yii::t('kalibao.backend','label_logistic_strategy_just_in_time'),
            'temporary_stockout' => Yii::t('kalibao.backend','label_logistic_strategy_temporary_stockout'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogisticStrategyI18ns()
    {
        return $this->hasMany(LogisticStrategyI18n::className(), ['logistic_strategy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getLogisticStrategyI18n()
    {
        $i18ns = $this->logisticStrategyI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariants()
    {
        return $this->hasMany(Variant::className(), ['logistic_strategy_id' => 'id']);
    }

    public function getStrategy()
    {
        if ($this->real_stock)         return self::REAL_STOCK;
        if ($this->stockout)           return self::STOCKOUT;
        if ($this->preorder)           return self::PREORDER;
        if ($this->direct_delivery)    return self::DIRECT_DELIVERY;
        if ($this->just_in_time)       return self::JUST_IN_TIME;
        if ($this->temporary_stockout) return self::TEMPORARY_STOCKOUT;
        return false;
    }

    public function getAlternativeStrategy()
    {
        if ($this->real_stock) {
            if ($this->stockout)           return self::STOCKOUT;
            if ($this->direct_delivery)    return self::DIRECT_DELIVERY;
            if ($this->just_in_time)       return self::JUST_IN_TIME;
        }
        return false;
    }

    public function setStrategy($strategy) {
        switch ($strategy) {
            case self::STOCKOUT:
                $this->stockout = 1;
                break;
            case self::PREORDER:
                $this->preorder = 1;
                break;
            case self::REAL_STOCK:
                $this->real_stock = 1;
                break;
            case self::DIRECT_DELIVERY:
                $this->direct_delivery = 1;
                break;
            case self::JUST_IN_TIME:
                $this->just_in_time = 1;
                break;
            case self::TEMPORARY_STOCKOUT:
                $this->temporary_stockout = 1;
                break;
        }
    }

    public function setAlternativeStrategy($strategy) {
        if ($this->real_stock) {
            switch ($strategy) {
                case self::STOCKOUT:
                    $this->stockout = 1;
                    break;
                case self::DIRECT_DELIVERY:
                    $this->direct_delivery = 1;
                    break;

                case self::JUST_IN_TIME:
                    $this->just_in_time = 1;
                    break;
            }
        }
    }

    public function setLogisticData(array $data, $strategy = null)
    {
        switch (($strategy === null)?$this->strategy:$strategy) {
            case self::STOCKOUT:
                if (isset($data[self::STOCKOUT]['message']))
                    $this->setMessage($data[self::STOCKOUT]['message']);
                break;

            case self::PREORDER:
                $this->delivery_date = Date::dateToMysql($data[self::PREORDER]['date']);
                $this->setMessage($data[self::PREORDER]['message']);
                break;

            case self::REAL_STOCK:
                $this->alert_stock = $data[self::REAL_STOCK]['alert'];
                $this->setAlternativeStrategy($data[self::REAL_STOCK]['alternative']);
                $this->setLogisticData($data[self::REAL_STOCK], $data[self::REAL_STOCK]['alternative']);
                break;

            case self::DIRECT_DELIVERY:
                $this->supplier_id = $data[self::DIRECT_DELIVERY]['supplier'];
                $this->additional_delay = $data[self::DIRECT_DELIVERY]['delay'];
                break;

            case self::JUST_IN_TIME:
                $this->additional_delay = $data[self::JUST_IN_TIME]['delay'];
                break;
        }
    }

    public function setMessage($message)
    {
        if ($this->logisticStrategyI18n) {
            $this->logisticStrategyI18n->message = $message;
            $this->logisticStrategyI18n->scenario = 'update';
            $this->logisticStrategyI18n->save();
        } else {
            $i18n = new LogisticStrategyI18n(['scenario' => 'insert']);
            $i18n->logistic_strategy_id = $this->id;
            $i18n->i18n_id = Yii::$app->language;
            $i18n->message = $message;
            $i18n->save();
        }
    }

    public function clearData()
    {
        $attributes = [
            'stockout'           => 0,
            'preorder'           => 0,
            'real_stock'         => 0,
            'direct_delivery'    => 0,
            'just_in_time'       => 0,
            'temporary_stockout' => 0,
            'delivery_date'      => null,
            'alert_stock'        => null,
            'supplier_id'        => null,
            'additional_delay'   => null
        ];
        $this->attributes = $attributes;
    }
}
