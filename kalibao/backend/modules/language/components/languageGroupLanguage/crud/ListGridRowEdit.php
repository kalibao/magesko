<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\language\components\languageGroupLanguage\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRowEdit
 *
 * @package kalibao\backend\modules\language\components\languageGroupLanguage\crud
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
            'attribute' => 'language_group_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('language_group_i18n.title'),
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('language_group_id'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'language_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('language_i18n.title'),
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('language_id'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'activated',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $this->setItems($items);
    }
}