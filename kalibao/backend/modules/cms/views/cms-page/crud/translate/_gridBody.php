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
                            $currentModel = '';
                            if ($itemField->model->formName() === $crudTranslate->getModel()->formName()) {
                                $currentModel = $crudTranslate->models[$language][$itemField->model->formName()];
                                $options = array_merge($options, array('name' => $language.'['.$itemField->model->formName().']['.$itemField->attribute.']'));
                            } elseif ($itemField->model->formName() === $crudTranslate->pageContentModel->formName()) {
                                $currentModel = $crudTranslate->models[$language][$itemField->model->formName()][$itemField->options['data-index']];
                                $options = array_merge($options, array('name' => $language.'['.$itemField->model->formName().']['.$itemField->options['data-index'].']['.$itemField->attribute.']'));
                            }
                        ?>
                        <div class="form-group<?= ($hasError = $currentModel->hasErrors($itemField->attribute)) ? ' has-error' : ''; ?>">
                            <?php if (! empty($itemField->data)): ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$currentModel, $itemField->attribute, $itemField->data, $options]); ?>
                            <?php else: ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$currentModel, $itemField->attribute, $options]); ?>
                            <?php endif; ?>
                            <div class="control-label help-inline"><?= $hasError ? $currentModel->getFirstError($itemField->attribute) : ''; ?></div>
                        </div>
                    <?php elseif ($itemField instanceof SimpleValueField): ?>
                        <?= $itemField->value; ?>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</tbody>