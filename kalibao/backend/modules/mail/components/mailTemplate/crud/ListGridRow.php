<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\components\mailTemplate\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\mail\components\mailTemplate\crud
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
            isset($this->model->mailTemplateGroupI18ns[0]) ? $this->model->mailTemplateGroupI18ns[0]->title : '',
            isset($this->model->mailTemplateI18ns[0]) ? $this->model->mailTemplateI18ns[0]->object : '',
            isset($this->model->mailTemplateI18ns[0]) ? $this->model->mailTemplateI18ns[0]->message : '',
        ]);
    }
}