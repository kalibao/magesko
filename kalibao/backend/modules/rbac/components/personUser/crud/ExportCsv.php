<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\rbac\components\personUser\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;
use kalibao\common\models\user\User;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\rbac\components\person\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ExportCsv extends ActiveRecordCsv
{
    /**
     * @var
     */
    private $statusLabels;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->statusLabels = User::statusLabels();

        $this->setHeader([
            '#',
            'first_name' => true,
            'last_name' => true,
            'email' => true,
            'language_i18n_title' => true,
            'user_status' => true,
            'user_active_password_reset' => true,
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
            $model->first_name,
            $model->last_name,
            $model->email,
            isset($model->languageI18ns[0]) ? $model->languageI18ns[0]->title : '',
            isset($model->user) ? $this->statusLabels[$model->user->status] : '',
            isset($model->user) ? $model->user->active_password_reset : '',
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}