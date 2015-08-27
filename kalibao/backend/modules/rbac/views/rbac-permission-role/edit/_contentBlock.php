<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

\kalibao\backend\modules\rbac\components\rbacPermissionRole\web\RbacPermissionRoleAsset::register($this);

$this->registerJs("
    new $.kalibao.backend.rbac.RbacPermissionRoleEdit({
        id: 'rbac_rbac-permission-role_edit'
    });
");
?>
<div class="content-block" id="rbac_rbac-permission-role_edit">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('_header', ['title' => $title]); ?>
        <?= $this->render('_content', ['models' => $models, 'isSaved' => $isSaved, 'hasErrors' => $hasErrors]); ?>
    </div>
</div>