<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\attribute\components\attribute\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\attribute\components\attribute\crud
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
            isset($this->model->attributeTypeI18ns[0]) ? $this->model->attributeTypeI18ns[0]->value : '',
            isset($this->model->attributeI18ns[0]) ? $this->model->attributeI18ns[0]->value : '',
        ]);
    }
}