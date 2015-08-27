<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\variable\components\variable\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\variable\components\variable\crud
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
            isset($this->model->variableGroupI18ns[0]) ? $this->model->variableGroupI18ns[0]->title : '',
            $this->model->name,
            $this->model->val,
            isset($this->model->variableI18ns[0]) ? $this->model->variableI18ns[0]->description : '',
        ]);
    }
}