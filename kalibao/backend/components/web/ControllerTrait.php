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
trait ControllerTrait
{
    /**
     * Register client side
     */
    protected function registerClientSideApp()
    {
        $this->getView()->registerJs('$.kalibao.app = new $.kalibao.backend.App();');
    }

    /**
     * Register client side ajax script
     * @return array
     */
    protected function registerClientSideAjaxScript()
    {
        return [
            '$(\'.current-language\').replaceWith(\''.preg_replace("/\r|\n/", '', LanguageMenuWidget::widget()).'\');',
            '$.kalibao.app.initChangeLanguageEvent();'
        ];
    }
}