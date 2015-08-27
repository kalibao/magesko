<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\SimpleValueField;
?>
<tbody>
    <?php foreach($crudEdit->items as $itemField): ?>
        <tr>
            <th><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
            <td>
                <?php if ($itemField instanceof InputField): ?>
                    <div class="form-group">
                        <?php if (! empty($itemField->data)): ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->data, $itemField->options]); ?>
                        <?php else: ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->options]); ?>
                        <?php endif; ?>
                        <div class="control-label help-inline"></div>
                    </div>
                <?php elseif ($itemField instanceof DateRangeField): ?>
                    <div class="form-group">
                        <?= Yii::t('kalibao', 'date_range_between'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->start->type], [$itemField->start->model, $itemField->start->attribute, $itemField->start->options]); ?>
                        <?= Yii::t('kalibao', 'date_range_separator'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->end->type], [$itemField->end->model, $itemField->end->attribute, $itemField->end->options]); ?>
                        <div class="control-label help-inline"></div>
                    </div>
                <?php elseif ($itemField instanceof SimpleValueField): ?>
                    <?= $itemField->value; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>