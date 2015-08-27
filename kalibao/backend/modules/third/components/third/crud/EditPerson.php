<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\third\crud;

use kalibao\common\models\language\LanguageI18n;
use kalibao\common\models\person\PersonGenderI18n;
use kalibao\common\models\third\Third;
use kalibao\common\models\user\User;
use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\third\ThirdRoleI18n;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\third\components\third\crud
 * @version 1.0
 */
class EditPerson extends \kalibao\common\components\crud\Edit
{
    public function getAction()
    {
        if ($this->models['main']->isNewRecord) {
            return Url::to(['create-third', 'interface' => (int)Third::PERSON_INTERFACE]);
        } else {
            return Url::to(['update'] + $this->models['main']->getPrimaryKey(true));
        }
    }
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set titles
        $this->setCreateTitle(Yii::t('kalibao', 'create_title'));
        $this->setUpdateTitle(Yii::t('kalibao', 'update_title'));

        // models
        $models = $this->getModels();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // upload config
        $uploadConfig['main'] = $this->uploadConfig[(new \ReflectionClass($models['main']))->getName()];
        $uploadConfig['person'] = $this->uploadConfig[(new \ReflectionClass($models['person']))->getName()];

        // set items
        $items = [];

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'first_name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('first_name'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'last_name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('last_name'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'email',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('email'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'default_language',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'language_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['person']->default_language) ? LanguageI18n::findOne([
                    'language_id' => $models['person']->default_language,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'user_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'user.username',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['person']->user_id) ? User::findOne([
                    'id' => $models['person']->user_id
                ])->username : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'gender_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'person_gender_i18n.title',
                ]),
                'data-add-action' => Url::to('/third/person-gender/create'),
                'data-update-action' => Url::to('/third/person-gender/update'),
                'data-update-argument' => 'id',
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['person']->gender_id) ? PersonGenderI18n::findOne([
                    'gender_id' => $models['person']->gender_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'phone_1',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('phone_1'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'phone_2',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('phone_2'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'fax',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('fax'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'website',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('website'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'birthday',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm date-picker date-range',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('birthday'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['person'],
            'attribute' => 'skype',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['person']->getAttributeLabel('skype'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'note',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('note'),
            ]
        ]);

        if (!$models['main']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['person'],
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->created_at, I18N::getDateFormat())
            ]);
            $items[] = new SimpleValueField([
                'model' => $models['person'],
                'attribute' => 'updated_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->updated_at, I18N::getDateFormat())
            ]);
        }

        $this->setItems($items);
    }
}