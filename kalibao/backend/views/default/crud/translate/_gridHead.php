<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use \kalibao\common\components\helpers\Html;
?>
<thead>
<tr class="form-inline">
    <th></th>
    <?php foreach ($crudTranslate->items as $itemField): ?>
        <th><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
    <?php endforeach; ?>
</tr>
</thead>