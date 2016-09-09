<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
use yii\helpers\Url;

?>
<tr class="form-inline">
    <?= $this->render('crud/list/_gridBodyRowInlineActions', ['row' => $row], $this->context); ?>
    <?php
    $first = $row->items[0];
    ?>
    <?php foreach ($row->items as $item): ?>
        <?php if ($item == $first): ?>
            <td>
                <a href="<?= Url::to(['view'] + $row->getPk()); ?>" class="btn-view <?= $row->model->is_pack?'pack':'' ?>" title="<?= Yii::t('kalibao', 'btn_view'); ?>">
                    <?= $item; ?>
                </a>
            </td>
        <?php else: ?>
            <td><?= $item; ?></td>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= $this->render('crud/list/_gridBodyRowActions', ['row' => $row], $this->context); ?>
</tr>