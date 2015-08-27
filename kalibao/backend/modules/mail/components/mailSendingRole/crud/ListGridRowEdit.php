<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\components\mailSendingRole\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\person\Person;
use kalibao\common\models\mailSendRole\MailSendRoleI18n;

/**
 * Class ListGridRowEdit
 *
 * @package kalibao\backend\modules\mail\components\mailSendingRole\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGridRowEdit extends \kalibao\common\components\crud\ListGridRowEdit
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // models
        $models = $this->getModels();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // upload config
        $uploadConfig['main'] = $this->uploadConfig[(new \ReflectionClass($models['main']))->getName()];

        // set items
        $items = [];

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'mail_send_role_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('mail_send_role_i18n.title'),
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('mail_send_role_id'),
            ]
        ]);

        $person = Person::findOne(['id' => $models['main']->person_id]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'person_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'person.full_name',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => $person !== null ? $person->first_name.' '.$person->last_name : '',
            ]
        ]);


        $this->setItems($items);
    }
}