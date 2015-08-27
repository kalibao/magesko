<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\branch\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\tree\components\branch\crud
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
            isset($this->model->branchTypeI18ns[0]) ? $this->model->branchTypeI18ns[0]->label : '',
            isset($this->model->treeI18ns[0]) ? $this->model->treeI18ns[0]->label : '',
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->label : '',
            $this->model->order,
            isset($this->model->mediaI18ns[0]) ? $this->model->mediaI18ns[0]->title : '',
            Html::activeCheckbox($this->model, 'visible', ['disabled' => 'disabled', 'label' => '']),
            $this->model->background,
            Html::activeCheckbox($this->model, 'presentation_type', ['disabled' => 'disabled', 'label' => '']),
            $this->model->offset,
            Html::activeCheckbox($this->model, 'display_brands_types', ['disabled' => 'disabled', 'label' => '']),
            Html::activeCheckbox($this->model, 'big_menu_only_first_level', ['disabled' => 'disabled', 'label' => '']),
            Html::activeCheckbox($this->model, 'unfold', ['disabled' => 'disabled', 'label' => '']),
            isset($this->model->googleShoppingCategory) ? $this->model->googleShoppingCategory->id : '',
            Html::activeCheckbox($this->model, 'google_shopping', ['disabled' => 'disabled', 'label' => '']),
            isset($this->model->affiliationCategory) ? $this->model->affiliationCategory->id : '',
            Html::activeCheckbox($this->model, 'affiliation', ['disabled' => 'disabled', 'label' => '']),
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->label : '',
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->description : '',
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->url : '',
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->meta_title : '',
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->meta_description : '',
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->meta_keywords : '',
            isset($this->model->branchI18ns[0]) ? $this->model->branchI18ns[0]->h1_tag : '',
            Yii::$app->formatter->asDatetime($this->model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($this->model->updated_at, I18N::getDateFormat()),
        ]);
    }
}