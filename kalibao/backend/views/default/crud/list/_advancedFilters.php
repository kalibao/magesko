<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\SimpleValueField;
?>
<div class="advanced-filters">
    <h4>
        <?= Yii::t('kalibao', 'list_advanced_search_title')?>
        <button type="button" class="close" aria-hidden="true">&times;</button>
    </h4>

    <form method="GET" action="<?= Url::to(['list']); ?>">
        <table class="table table-condensed">
            <tbody>
            <?php foreach ($crudList->advancedFilters as $itemField): ?>
                <tr>
                    <th><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
                    <td class="form-inline">
                        <?php if ($itemField instanceof InputField): ?>
                            <?php if (! empty($itemField->data)): ?>
                                <div class="form-group-inline">
                                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->data, $itemField->options]); ?>
                                    <div class="help-inline"></div>
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->options]); ?>
                                    <div class="help-inline"></div>
                                </div>
                            <?php endif; ?>
                        <?php elseif ($itemField instanceof DateRangeField): ?>
                            <div class="form-group">
                                <?= Yii::t('kalibao', 'date_range_between'); ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->start->type], [$itemField->start->model, $itemField->start->attribute, $itemField->start->options]); ?>
                                <?= Yii::t('kalibao', 'date_range_separator'); ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->end->type], [$itemField->end->model, $itemField->end->attribute, $itemField->end->options]); ?>
                                <div class="help-inline"></div>
                            </div>
                        <?php elseif ($itemField instanceof SimpleValueField): ?>
                            <?= $itemField->value; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <a href="#" class="btn btn-primary btn-search">
                        <span class="glyphicon glyphicon-search"></span>
                        <span><?= Yii::t('kalibao', 'btn_search'); ?></span>
                    </a>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>