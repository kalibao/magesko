<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\companyContact\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\third\components\companyContact\crud
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
            isset($this->model->company) ? $this->model->company->name : '',
            isset($this->model->person) ? $this->model->person->last_name : '',
            Html::activeCheckbox($this->model, 'is_primary', ['disabled' => 'disabled', 'label' => '']),
            Yii::$app->formatter->asDatetime($this->model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($this->model->updated_at, I18N::getDateFormat()),
        ]);
    }
}