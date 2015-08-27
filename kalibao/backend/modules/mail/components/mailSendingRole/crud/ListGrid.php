<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\components\mailSendingRole\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
use kalibao\common\models\person\Person;
use kalibao\common\models\mailSendRole\MailSendRoleI18n;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\mail\components\mailSendingRole\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGrid extends \kalibao\common\components\crud\ListGrid
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // get model
        $model = $this->getModel();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // set titles
        $this->setTitle(Yii::t('kalibao.backend', 'mail_mail_sending_role_list_title'));

        // set head attributes
        $this->setGridHeadAttributes([
            'mail_send_role_id' => true,
            'person_full_name' => true,
        ]);
    }
}