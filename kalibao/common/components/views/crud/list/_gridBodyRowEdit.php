<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\SimpleValueField;
?>
<tr class="form-inline">
    <?= $this->render('crud/list/_gridBodyRowEditActions', ['crudListFieldEdit' => $crudListFieldsEdit], $this->context); ?>
    <?php foreach($crudListFieldsEdit->items as $itemField): ?>
        <td>
            <?php if ($itemField instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $itemField->model->hasErrors($itemField->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($itemField->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->data, $itemField->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"><?= $hasError ? $itemField->model->getFirstError($itemField->attribute) : ''; ?></div>
                </div>
            <?php elseif ($itemField instanceof SimpleValueField): ?>
                <?= $itemField->value; ?>
            <?php endif; ?>
        </td>
    <?php endforeach; ?>
    <td></td>
</tr>