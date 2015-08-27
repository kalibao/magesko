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
<?php if (! empty($crudList->gridHeadFilters)): ?>
    <tr class="head-filters form-inline">
        <td class="td-search">
            <a href="<?= Url::to(['list'] + (isset($crudList->requestParams['modal']) ? ['modal' => $crudList->requestParams['modal']] : [])); ?>" class="btn btn-sm btn-default btn-search" title="<?= Yii::t('kalibao', 'btn_search'); ?>">
                <span class="glyphicon glyphicon-search"></span>
            </a>
        </td>

        <?php foreach($crudList->gridHeadFilters as $itemField): ?>
            <td>
                <?php if ($itemField instanceof InputField): ?>
                    <div class="form-group<?= ($hasError = $itemField->model->hasErrors($itemField->attribute)) ? ' has-error' : ''; ?>">
                        <?php if ($itemField->data !== null): ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->data, $itemField->options]); ?>
                        <?php else: ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->options]); ?>
                        <?php endif; ?>
                        <div class="help-inline"><?= $hasError ? $itemField->model->getFirstError($itemField->attribute) : ''; ?></div>
                    </div>
                <?php elseif ($itemField instanceof DateRangeField): ?>
                    <div class="form-group<?= ($hasError = ($itemField->start->model->hasErrors($itemField->start->attribute) || $itemField->end->model->hasErrors($itemField->end->attribute))) ? ' has-error' : ''; ?>">
                        <?= Yii::t('kalibao', 'date_range_between'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->start->type], [$itemField->start->model, $itemField->start->attribute, $itemField->start->options]); ?>
                        <?= Yii::t('kalibao', 'date_range_separator'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->end->type], [$itemField->end->model, $itemField->end->attribute, $itemField->end->options]); ?>
                        <div class="help-inline">
                            <?php if($hasError): ?>
                                <?php if( ($errorDateStart = $itemField->start->model->getFirstError($itemField->start->attribute)) !== null): ?>
                                    <?= $errorDateStart; ?>.
                                <?php endif; ?>
                                <?php if( ($errorDateEnd = $itemField->end->model->getFirstError($itemField->end->attribute)) !== null): ?>
                                    <?= $errorDateEnd; ?>.
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php elseif ($itemField instanceof SimpleValueField): ?>
                    <?= $itemField->value; ?>
                <?php endif; ?>
            </td>
        <?php endforeach; ?>

        <td class="td-search">
            <a href="<?= Url::to(['list'] + (isset($crudList->requestParams['modal']) ? ['modal' => $crudList->requestParams['modal']] : [])); ?>" class="btn btn-sm btn-default btn-search" title="<?= Yii::t('kalibao', 'btn_search'); ?>">
                <span class="glyphicon glyphicon-search"></span>
            </a>
        </td>
    </tr>
<?php endif; ?>