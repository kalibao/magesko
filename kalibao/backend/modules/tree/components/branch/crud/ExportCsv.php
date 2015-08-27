<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\branch\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\tree\components\branch\crud
 * @version 1.0
 */
class ExportCsv extends ActiveRecordCsv
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setHeader([
            '#',
            'branch_type_i18n_label' => true,
            'tree_i18n_label' => true,
            'branch_i18n_label' => true,
            'order' => true,
            'media_i18n_title' => true,
            'visible' => true,
            'background' => true,
            'presentation_type' => true,
            'offset' => true,
            'display_brands_types' => true,
            'big_menu_only_first_level' => true,
            'unfold' => true,
            'google_shopping_category_id' => true,
            'google_shopping' => true,
            'affiliation_category_id' => true,
            'affiliation' => true,
            'branch_i18n_label' => true,
            'branch_i18n_description' => true,
            'branch_i18n_url' => true,
            'branch_i18n_meta_title' => true,
            'branch_i18n_meta_description' => true,
            'branch_i18n_meta_keywords' => true,
            'branch_i18n_h1_tag' => true,
            'created_at' => true,
            'updated_at' => true,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getRow(ActiveRecord $model)
    {
        return [
            $model->id,
            isset($model->branchTypeI18ns[0]) ? $model->branchTypeI18ns[0]->label : '',
            isset($model->treeI18ns[0]) ? $model->treeI18ns[0]->label : '',
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->label : '',
            $model->order,
            isset($model->mediaI18ns[0]) ? $model->mediaI18ns[0]->title : '',
            $model->visible,
            $model->background,
            $model->presentation_type,
            $model->offset,
            $model->display_brands_types,
            $model->big_menu_only_first_level,
            $model->unfold,
            isset($model->googleShoppingCategory) ? $model->googleShoppingCategory->id : '',
            $model->google_shopping,
            isset($model->affiliationCategory) ? $model->affiliationCategory->id : '',
            $model->affiliation,
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->label : '',
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->description : '',
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->url : '',
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->meta_title : '',
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->meta_description : '',
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->meta_keywords : '',
            isset($model->branchI18ns[0]) ? $model->branchI18ns[0]->h1_tag : '',
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}