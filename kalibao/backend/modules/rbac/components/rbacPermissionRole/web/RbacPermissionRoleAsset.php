<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\rbac\components\rbacPermissionRole\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class RbacPermissionRoleAsset
 *
 * @package kalibao\backend\modules\rbac\components\rbacPermissionRole\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class RbacPermissionRoleAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/rbac/components/rbacPermissionRole/resources';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/kalibao.backend.rbac.RbacPermissionRoleEdit.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\common\components\web\AppAsset'
    ];
}