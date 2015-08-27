<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud
 * @version 1.0
 */
class ListGridRow extends \kalibao\common\components\crud\ListGridRow
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set items
        $this->setItems([
            Html::activeCheckbox($this->model, 'stockout', ['disabled' => 'disabled', 'label' => '']),
            Html::activeCheckbox($this->model, 'preorder', ['disabled' => 'disabled', 'label' => '']),
            Yii::$app->formatter->asDatetime($this->model->delivery_date, I18N::getDateFormat()),
            Html::activeCheckbox($this->model, 'real_stock', ['disabled' => 'disabled', 'label' => '']),
            $this->model->alert_stock,
            Html::activeCheckbox($this->model, 'direct_delivery', ['disabled' => 'disabled', 'label' => '']),
            isset($this->model->supplier) ? $this->model->supplier->name : '',
            $this->model->additional_delay,
            Html::activeCheckbox($this->model, 'just_in_time', ['disabled' => 'disabled', 'label' => '']),
            Html::activeCheckbox($this->model, 'temporary_stockout', ['disabled' => 'disabled', 'label' => '']),
            isset($this->model->logisticStrategyI18ns[0]) ? $this->model->logisticStrategyI18ns[0]->message : '',
        ]);
    }
}