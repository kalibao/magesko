<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\tree\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\tree\components\tree\crud
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
            'tree_type_i18n_label' => true,
            'media_i18n_title' => true,
            'tree_i18n_label' => true,
            'tree_i18n_description' => true,
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
            isset($model->treeTypeI18ns[0]) ? $model->treeTypeI18ns[0]->label : '',
            isset($model->mediaI18ns[0]) ? $model->mediaI18ns[0]->title : '',
            isset($model->treeI18ns[0]) ? $model->treeI18ns[0]->label : '',
            isset($model->treeI18ns[0]) ? $model->treeI18ns[0]->description : '',
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}