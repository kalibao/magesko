<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\brand\components\brand\crud;

use Yii;
use kalibao\common\components\crud\InputField;

/**
 * Class Translate
 *
 * @package kalibao\backend\modules\brand\components\brand\crud
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


        $this->setItems($items);
    }
}