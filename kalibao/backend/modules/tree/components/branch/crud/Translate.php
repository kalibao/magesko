<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\branch\crud;

use Yii;
use kalibao\common\components\crud\InputField;

/**
 * Class Translate
 *
 * @package kalibao\backend\modules\tree\components\branch\crud
 * @version 1.0
 */
class Translate extends \kalibao\common\components\crud\Translate
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // model
        $model = $this->getModel();

        // language
        $language = $this->getLanguage();

        // set items
        $items = [];

        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'label',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('label'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'url',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('url'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'meta_title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('meta_title'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'meta_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $model->getAttributeLabel('meta_description'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'meta_keywords',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('meta_keywords'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'h1_tag',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('h1_tag'),
            ]
        ]);

        $this->setItems($items);
    }
}