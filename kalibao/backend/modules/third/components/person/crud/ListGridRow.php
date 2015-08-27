<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\person\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\third\components\person\crud
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
            isset($this->model->third) ? $this->model->third->id : '',
            $this->model->first_name,
            $this->model->last_name,
            $this->model->email,
            isset($this->model->languageI18ns[0]) ? $this->model->languageI18ns[0]->title : '',
            isset($this->model->user) ? $this->model->user->username : '',
            isset($this->model->personGenderI18ns[0]) ? $this->model->personGenderI18ns[0]->title : '',
            $this->model->phone_1,
            $this->model->phone_2,
            $this->model->fax,
            $this->model->website,
            Yii::$app->formatter->asDatetime($this->model->birthday, I18N::getDateFormat()),
            $this->model->skype,
            Yii::$app->formatter->asDatetime($this->model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($this->model->updated_at, I18N::getDateFormat()),
        ]);
    }
}