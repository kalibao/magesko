<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\SimpleValueField;
?>
<tbody>
    <?php foreach ($crudSetting->items as $itemField): ?>
        <tr>
            <th><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
            <td>
                <?php if ($itemField instanceof InputField): ?>
                    <?php if (! empty($itemField->data)): ?>
                        <div class="form-group">
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->data, $itemField->options]); ?>
                            <div class="form-label help-inline"></div>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->options]); ?>
                            <div class="control-label help-inline"></div>
                        </div>
                    <?php endif; ?>
                <?php elseif ($itemField instanceof SimpleValueField): ?>
                    <?= $itemField->value; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>