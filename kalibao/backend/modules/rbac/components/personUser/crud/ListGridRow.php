<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\rbac\components\personUser\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\user\User;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\rbac\components\person\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGridRow extends \kalibao\common\components\crud\ListGridRow
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $statusLabels = User::statusLabels();

        // set items
        $this->setItems([
            $this->model->first_name,
            $this->model->last_name,
            $this->model->email,
            isset($this->model->languageI18ns[0]) ? $this->model->languageI18ns[0]->title : '',
            isset($this->model->user) ? $statusLabels[$this->model->user->status] : '',
        ]);
    }
}