<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\helpers\Html;
?>
<tr class="head-titles">
    <th class="th-quick-action"><span class="glyphicon glyphicon-list"></span></th>
    <?php foreach ($crudList->gridHeadAttributes as $attribute => $sortable): ?>
        <th>
            <?php if ($sortable === true): ?>
                <?= Html::sortLink($crudList->dataProvider->sort, $attribute); ?>
            <?php elseif ($sortable === false): ?>
                <?= $crudList->getModel('filter')->getAttributeLabel($attribute); ?>
            <?php else: ?>
                <?= $sortable ?>
            <?php endif; ?>
        </th>
    <?php endforeach; ?>
    <th></th>
</tr>