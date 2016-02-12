<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\helpers\Html;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\SimpleValueField;
?>
<tbody>
<?php $i=0; foreach ($models['rbacPermissions'] as $rbacPermission): ?>
    <?php $i++; if (($i%25) === 0): ?>
        <tr>
            <th class="text-center">
                <a class="btn btn-default" href="#" title="top"><i class="fa fa-arrow-up"></i></a>
                <a class="btn btn-default" href="#bottom" title="bottom"><i class="fa fa-arrow-down"></i></a>
            </th>
            <?php foreach ($models['rbacRoles'] as $rbacRole): ?>
                <?php if (isset($rbacRole->rbacRoleI18ns[0])): ?>
                    <th><?= $rbacRole->rbacRoleI18ns[0]->title ?></th>
                <?php endif ?>
            <?php endforeach ?>
        </tr>
    <?php endif; ?>
    <?php if (isset($rbacPermission->rbacPermissionI18ns[0])): ?>
    <tr>
        <td><?= $rbacPermission->rbacPermissionI18ns[0]->title; ?></td>
        <?php foreach ($models['rbacRoles'] as $rbacRole): ?>
            <?php if (isset($rbacRole->rbacRoleI18ns[0])): ?>
                <td>
                    <?= Html::hiddenInput('rbacRolesPermissions['.$rbacRole->id.']['.$rbacPermission->id.']', 0) ?>
                    <?= Html::checkbox('rbacRolesPermissions['.$rbacRole->id.']['.$rbacPermission->id.']', $models['rbacRolesPermissions'][$rbacRole->id][$rbacPermission->id]->rbac_role_id == $rbacRole->id) ?>
                </td>
            <?php endif ?>
        <?php endforeach ?>
    </tr>
    <?php endif ?>
<?php endforeach ?>
</tbody>