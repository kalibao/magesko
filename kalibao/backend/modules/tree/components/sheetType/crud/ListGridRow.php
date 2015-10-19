<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\sheetType\crud;

use kalibao\common\models\sheetType\SheetType;
use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\tree\components\sheetType\crud
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
            $this->model->id,
            $this->model->url_pick,
            $this->model->table,
            $this->model->url_zoom_front,
            $this->model->url_zoom_back,
            isset($this->model->sheetTypeI18ns[0]) ? $this->model->sheetTypeI18ns[0]->label : '',
            Yii::$app->formatter->asDatetime($this->model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($this->model->updated_at, I18N::getDateFormat()),
        ]);
    }
}