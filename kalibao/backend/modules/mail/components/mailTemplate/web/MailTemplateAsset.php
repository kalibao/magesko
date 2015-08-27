<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\mail\components\mailTemplate\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class MailTemplateAsset
 *
 * @package kalibao\backend\modules\mail\components\mailTemplate\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailTemplateAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/mail/components/mailTemplate/resources';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        //'forceCopy' => YII_ENV_DEV
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/kalibao.backend.mail.MailTemplateList.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/css/kalibao.backend.mail.mail-template.css'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}