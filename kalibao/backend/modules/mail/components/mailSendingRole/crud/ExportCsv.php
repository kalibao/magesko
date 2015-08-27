<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\components\mailSendingRole\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\mail\components\mailSendingRole\crud
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
            'person_first_name' => true,
            'mail_template_id' => true,
            'mail_send_role_id' => true,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getRow(ActiveRecord $model)
    {
        return [
            isset($model->person) ? $model->person->first_name : '',
            isset($model->mailTemplate) ? $model->mailTemplate->id : '',
            isset($model->mailSendRole) ? $model->mailSendRole->id : '',
        ];
    }
}