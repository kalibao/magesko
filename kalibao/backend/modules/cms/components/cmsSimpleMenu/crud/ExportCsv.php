<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsSimpleMenu\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\cms\components\cmsSimpleMenu\crud
 * @version 1.0
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
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
            'cms_simple_menu_group_i18n_title' => true,
            'position' => true,
            'cms_simple_menu_i18n_title' => true,
            'cms_simple_menu_i18n_url' => true,
            '#',
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
            isset($model->cmsSimpleMenuGroupI18ns[0]) ? $model->cmsSimpleMenuGroupI18ns[0]->title : '',
            $model->position,
            isset($model->cmsSimpleMenuI18ns[0]) ? $model->cmsSimpleMenuI18ns[0]->title : '',
            isset($model->cmsSimpleMenuI18ns[0]) ? $model->cmsSimpleMenuI18ns[0]->url : '',
            $model->id,
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}