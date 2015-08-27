<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\site\controllers;

use Yii;
use kalibao\backend\components\web\Controller;

/**
 * Site controller
 *
 * @package kalibao\backend\modules\site\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
