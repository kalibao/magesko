<?php
use kalibao\common\components\helpers\Html;
?>
<?php foreach ($crudEdit->items['pageContents'] as $index => $itemField): ?>
    <?php if ($itemField->model->scenario !== 'delete'): ?>
    <tr class="page-contents">
        <th><?= $itemField->label ?> </th>
        <td>
            <div class="form-group<?= $hasError = $itemField->model->hasErrors('content') ? ' has-error' : ''; ?>">
                <?=
                    Html::activeTextarea(
                        $itemField->model,
                        $itemField->attribute,
                        $itemField->options
                    );
                ?>
                <div class="control-label help-inline"><?= $hasError ? $itemField->model->getFirstError($itemField->attribute) : ''; ?></div>
            </div>
        </td>
    </tr>
    <?php endif; ?>
<?php endforeach; ?>