<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\address\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\third\components\address\crud
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
            isset($this->model->addressTypeI18ns[0]) ? $this->model->addressTypeI18ns[0]->title : '',
            $this->model->label,
            $this->model->place_1,
            $this->model->street_number,
            $this->model->zip_code,
            $this->model->city,
            $this->model->country,
            Html::activeCheckbox($this->model, 'is_primary', ['disabled' => 'disabled', 'label' => '']),
        ]);
    }
}