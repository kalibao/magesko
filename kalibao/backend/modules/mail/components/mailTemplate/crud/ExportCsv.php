<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\components\mailTemplate\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\mail\components\mailTemplate\crud
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
            '#',
            'mail_template_group_i18n_title' => true,
            'html_mode' => true,
            'sql_request' => true,
            'sql_param' => true,
            'mail_template_i18n_object' => true,
            'mail_template_i18n_message' => true,
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
            isset($model->mailTemplateGroupI18ns[0]) ? $model->mailTemplateGroupI18ns[0]->title : '',
            $model->html_mode,
            $model->sql_request,
            $model->sql_param,
            isset($model->mailTemplateI18ns[0]) ? $model->mailTemplateI18ns[0]->object : '',
            isset($model->mailTemplateI18ns[0]) ? $model->mailTemplateI18ns[0]->message : '',
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}