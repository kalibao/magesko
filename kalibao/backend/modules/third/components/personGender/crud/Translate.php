<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\personGender\crud;

use Yii;
use kalibao\common\components\crud\InputField;

/**
 * Class Translate
 *
 * @package kalibao\backend\modules\third\components\personGender\crud
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
            'attribute' => 'gender_id',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('gender_id'),
            ]
        ]);
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

        $this->setItems($items);
    }
}