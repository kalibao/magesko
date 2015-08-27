<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsNews\crud;

use Yii;
use kalibao\common\components\crud\InputField;
use yii\helpers\Url;

/**
 * Class Translate
 *
 * @package kalibao\backend\modules\cms\components\cmsNews\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
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
            'attribute' => 'title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('title'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $model,
            'attribute' => 'content',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-filebrowser-browse-url' => Url::to(['cms-image/list', 'mode' => 'explorer']),
                'data-ckeditor-language' => $language,
            ]
        ]);

        $this->setItems($items);
    }
}