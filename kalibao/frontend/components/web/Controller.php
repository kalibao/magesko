<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\components\web;

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
    /**
     * @inheritdoc
     */
    protected function registerClientSide()
    {}

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->autoRedirect();
    }

    /**
     * Auto redirect
     */
    public function autoRedirect() {
        if (Yii::$app->request->url === '/') {
            $this->redirect('/'.Yii::$app->language, 301);
        }
    }

}
