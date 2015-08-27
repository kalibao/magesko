<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\treeType\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\tree\components\treeType\crud
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
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}