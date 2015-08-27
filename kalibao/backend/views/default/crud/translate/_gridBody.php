<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\SimpleValueField;
?>
<tbody>
    <?php foreach ($crudTranslate->items as $itemField): ?>
        <tr>
            <th><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
            <?php $options = $itemField->options; ?>
            <?php foreach ($crudTranslate->languages as $language): ?>
                <td>
                    <?php if ($itemField instanceof InputField): ?>
                        <?php
                            $options = array_merge($options, array('name' => $language.'['.(new ReflectionClass($crudTranslate->models[$language]))->getShortName().']['.$itemField->attribute.']'));
                        ?>
                        <div class="form-group<?= ($hasError = $crudTranslate->models[$language]->hasErrors($itemField->attribute)) ? ' has-error' : ''; ?>">
                            <?php if (! empty($itemField->data)): ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$crudTranslate->models[$language], $itemField->attribute, $itemField->data, $options]); ?>
                            <?php else: ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$crudTranslate->models[$language], $itemField->attribute, $options]); ?>
                            <?php endif; ?>
                            <div class="control-label help-inline"><?= $hasError ? $crudTranslate->models[$language]->getFirstError($itemField->attribute) : ''; ?></div>
                        </div>
                    <?php elseif ($itemField instanceof SimpleValueField): ?>
                        <?= $itemField->value; ?>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</tbody>