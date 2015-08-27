<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud
 * @version 1.0
 */
class ExportCsv extends ActiveRecordCsv
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setHeader([
            '#',
            'stockout' => true,
            'preorder' => true,
            'delivery_date' => true,
            'real_stock' => true,
            'alert_stock' => true,
            'direct_delivery' => true,
            'supplier_name' => true,
            'additional_delay' => true,
            'just_in_time' => true,
            'temporary_stockout' => true,
            'logistic_strategy_i18n_message' => true,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getRow(ActiveRecord $model)
    {
        return [
            $model->id,
            $model->stockout,
            $model->preorder,
            Yii::$app->formatter->asDatetime($model->delivery_date, I18N::getDateFormat()),
            $model->real_stock,
            $model->alert_stock,
            $model->direct_delivery,
            isset($model->supplier) ? $model->supplier->name : '',
            $model->additional_delay,
            $model->just_in_time,
            $model->temporary_stockout,
            isset($model->logisticStrategyI18ns[0]) ? $model->logisticStrategyI18ns[0]->message : '',
        ];
    }
}