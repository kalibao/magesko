<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\helpers\Html;
?>
<tr class="form-inline">
    <?= $this->render('crud/list/_gridBodyRowInlineActions', ['row' => $row], $this->context); ?>
    <td><?= $row->items['cms_image_i18n_title']; ?></td>
    <td><?= $row->items['cms_image_group_i18n_title']; ?></td>
    <td>
        <?= Html::img(
                $row->uploadConfig[(new \ReflectionClass($row->model))
                    ->getParentClass()->name]['file_path']['baseUrl'] . '/min/' . $row->model->file_path,
                ['width' => '200px', 'class' => 'overview']
            );
        ?>
    </td>
    <?= $this->render('crud/list/_gridBodyRowActions', ['row' => $row], $this->context); ?>
</tr>