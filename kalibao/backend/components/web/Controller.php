<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\components\web;

use Yii;

/**
 * Class Controller
 *
 * @package kalibao\backend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Controller extends \kalibao\common\components\web\Controller
{
    use ControllerTrait;

    /**
     * @inheritdoc
     */
    public $layout = '/main/main';

    /**
     * Register client side
     */
    protected function registerClientSide()
    {
        parent::registerClientSide();
        $this->registerClientSideApp();
    }
}
