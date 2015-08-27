<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\language\components\languageGroupLanguage\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\language\components\languageGroupLanguage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
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
            isset($this->model->languageGroupI18ns[0]) ? $this->model->languageGroupI18ns[0]->title : '',
            isset($this->model->languageI18ns[0]) ? $this->model->languageI18ns[0]->title : '',
            Html::activeCheckbox($this->model, 'activated', ['disabled' => 'disabled', 'label' => '']),
        ]);
    }
}