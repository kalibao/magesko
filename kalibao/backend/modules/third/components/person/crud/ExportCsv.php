<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\person\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\third\components\person\crud
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
            'third_id' => true,
            'first_name' => true,
            'last_name' => true,
            'email' => true,
            'language_i18n_title' => true,
            'user_username' => true,
            'person_gender_i18n_title' => true,
            'phone_1' => true,
            'phone_2' => true,
            'fax' => true,
            'website' => true,
            'birthday' => true,
            'skype' => true,
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
            isset($model->third) ? $model->third->id : '',
            $model->first_name,
            $model->last_name,
            $model->email,
            isset($model->languageI18ns[0]) ? $model->languageI18ns[0]->title : '',
            isset($model->user) ? $model->user->username : '',
            isset($model->personGenderI18ns[0]) ? $model->personGenderI18ns[0]->title : '',
            $model->phone_1,
            $model->phone_2,
            $model->fax,
            $model->website,
            Yii::$app->formatter->asDatetime($model->birthday, I18N::getDateFormat()),
            $model->skype,
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}