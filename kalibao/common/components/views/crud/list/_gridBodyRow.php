<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<tr class="form-inline">
    <?= $this->render('crud/list/_gridBodyRowInlineActions', ['row' => $row], $this->context); ?>
    <?php foreach ($row->items as $item): ?>
        <td><?= $item; ?></td>
    <?php endforeach; ?>
    <?= $this->render('crud/list/_gridBodyRowActions', ['row' => $row], $this->context); ?>
</tr>