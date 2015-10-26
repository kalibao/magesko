<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\SimpleValueField;

$group1 = ['visible', 'media_id', 'url'];
$group2 = ['h1_tag', 'meta_title', 'meta_keywords', 'meta_description']

?>
<div class="row">
    <div class="col-xs-12 form-group<?= ($hasError = $crudEdit->items['label']->model->hasErrors($crudEdit->items['label']->attribute)) ? ' has-error' : ''; ?>">
        <label class="control-label"><?= $crudEdit->items['label']->label !== null ? $crudEdit->items['label']->label : $crudEdit->items['label']->model->getAttributeLabel($crudEdit->items['label']->attribute); ?></label>
        <?php if (! empty($crudEdit->items['label']->data)): ?>
            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['label']->type], [$crudEdit->items['label']->model, $crudEdit->items['label']->attribute, $crudEdit->items['label']->data, $crudEdit->items['label']->options]); ?>
        <?php else: ?>
            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['label']->type], [$crudEdit->items['label']->model, $crudEdit->items['label']->attribute, $crudEdit->items['label']->options]); ?>
        <?php endif; ?>
        <div class="control-label help-inline"></div>
    </div>
    <?php foreach($group1 as $item): $itemField = $crudEdit->items[$item]?>
        <div class="col-xs-12 col-sm-4 form-group<?= ($hasError = $itemField->model->hasErrors($itemField->attribute)) ? ' has-error' : ''; ?>">
            <label class="control-label <?= ($itemField->required)? " required":"" ?>" for="<?= $itemField->id ?>"><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></label>
            <?php if (! empty($itemField->data)): ?>
                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->data, $itemField->options]); ?>
            <?php else: ?>
                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->options]); ?>
            <?php endif; ?>
            <div class="control-label help-inline"></div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <?php foreach($group2 as $item): $itemField = $crudEdit->items[$item]?>
                <div class="col-xs-12 form-group<?= ($hasError = $itemField->model->hasErrors($itemField->attribute)) ? ' has-error' : ''; ?>">
                    <label class="control-label <?= ($itemField->required)? " required":"" ?>" for="<?= $itemField->id ?>"><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></label>
                    <?php if (! empty($itemField->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->data, $itemField->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $itemField->type], [$itemField->model, $itemField->attribute, $itemField->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-xs-12 form-group<?= ($hasError = $crudEdit->items['description']->model->hasErrors($crudEdit->items['description']->attribute)) ? ' has-error' : ''; ?>">
                <label class="control-label"><?= $crudEdit->items['description']->label !== null ? $crudEdit->items['description']->label : $crudEdit->items['description']->model->getAttributeLabel($crudEdit->items['description']->attribute); ?></label>
                <?php if (! empty($crudEdit->items['description']->data)): ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['description']->type], [$crudEdit->items['description']->model, $crudEdit->items['description']->attribute, $crudEdit->items['description']->data, $crudEdit->items['description']->options]); ?>
                <?php else: ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['description']->type], [$crudEdit->items['description']->model, $crudEdit->items['description']->attribute, $crudEdit->items['description']->options]); ?>
                <?php endif; ?>
                <div class="control-label help-inline"></div>
            </div>
        </div>
    </div>
</div>
<?php if($crudEdit->models['main']->isNewRecord): ?>
    <div class="hidden">
        <input type="hidden" value="<?= Yii::$app->request->get('tree') ?>" name="Branch[tree_id]">
        <input type="hidden" value="1" name="Branch[parent]">
        <input type="hidden" value="1" name="Branch[branch_type_id]">
    </div>
<?php endif; ?>