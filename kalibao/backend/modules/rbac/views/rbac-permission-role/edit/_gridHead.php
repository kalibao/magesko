<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\SimpleValueField;
?>
<thead>
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
</thead>