<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\country\components\country\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRowEdit
 *
 * @package kalibao\backend\modules\country\components\country\crud
 * @version 1.0
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
            'attribute' => 'id',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('id'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'iso3',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('iso3'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'numcode',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('numcode'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'phonecode',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('phonecode'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('name'),
            ]
        ]);

        $items[] = new SimpleValueField([
            'model' => $models['main'],
            'attribute' => 'created_at',
            'value' => Yii::$app->formatter->asDatetime($models['main']->created_at, I18N::getDateFormat())
        ]);

        $items[] = new SimpleValueField([
            'model' => $models['main'],
            'attribute' => 'updated_at',
            'value' => Yii::$app->formatter->asDatetime($models['main']->updated_at, I18N::getDateFormat())
        ]);

        $this->setItems($items);
    }
}