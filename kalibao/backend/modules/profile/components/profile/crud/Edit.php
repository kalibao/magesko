<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\profile\components\profile\crud;

use kalibao\common\components\helpers\Html;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\language\LanguageI18n;
use kalibao\common\models\user\User;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\profile\components\profile\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Edit extends \kalibao\common\components\crud\Edit
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set titles
        $this->setUpdateTitle(Yii::t('kalibao.backend', 'rbac_user_update_title'));

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
            'attribute' => 'first_name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('first_name'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'last_name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('last_name'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'email',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('email'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
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
                'data-text' => !empty($models['main']->default_language) ? LanguageI18n::findOne([
                    'language_id' => $models['main']->default_language,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['user'],
            'attribute' => 'password',
            'type' => 'activePasswordInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['user']->getAttributeLabel('password'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['user'],
            'attribute' => 'password_repeat',
            'type' => 'activePasswordInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['user']->getAttributeLabel('password_repeat'),
            ]
        ]);

        $this->setItems($items);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return Url::to(['update']);
    }
}