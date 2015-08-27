<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsNews\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\cms\components\cmsNews\crud
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
            isset($this->model->cmsNewsI18ns[0]) ? $this->model->cmsNewsI18ns[0]->title : '',
            isset($this->model->cmsNewsGroupI18ns[0]) ? $this->model->cmsNewsGroupI18ns[0]->title : '',
            Html::activeCheckbox($this->model, 'activated', ['disabled' => 'disabled', 'label' => '']),
            Yii::$app->formatter->asDatetime($this->model->published_at, I18N::getDateFormat(I18N::DATE_FORMAT)),
        ]);
    }
}