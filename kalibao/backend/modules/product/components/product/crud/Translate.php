<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\product\components\product\crud;

use Yii;
use kalibao\common\components\crud\InputField;

/**
 * Class Translate
 *
 * @package kalibao\backend\modules\product\components\product\crud
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
            'attribute' => 'short_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'long_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'comment',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'page_title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('page_title'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('name'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'infos_shipping',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
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

        $this->setItems($items);
    }
}