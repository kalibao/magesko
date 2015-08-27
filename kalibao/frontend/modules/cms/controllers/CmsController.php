<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\cms\controllers;

use kalibao\frontend\components\web\Controller;
use kalibao\common\components\cms\CmsContentBehavior;

/**
 * Class CmsController
 *
 * @package kalibao\frontend\modules\cms\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            CmsContentBehavior::className()
        ];
    }

    /**
     * Default action
     */
    public function actionIndex()
    {
        return $this->render($this->renderView);
    }
}
