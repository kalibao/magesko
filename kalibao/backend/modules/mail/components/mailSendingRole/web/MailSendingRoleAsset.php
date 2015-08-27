<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\mail\components\mailSendingRole\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class MailSendingRole
 *
 * @package kalibao\backend\modules\mail\components\mailSendingRole\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailSendingRoleAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/mail/components/mailSendingRole/resources';

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
        'dist/js/kalibao.backend.mail.MailSendingRoleList.js',
        'dist/js/kalibao.backend.mail.MailSendingRoleEdit.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}