<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$col_1 = ['short_description', 'long_description', 'meta_description'];
$col_2 = ['comment', 'infos_shipping', 'meta_keywords'];
?>

<div class="tab-pane" id="description">
    <form method="POST" action="<?= $component->action; ?>">
        <div class="row">
            <div class="col-xs-4">
                <label for="<?= $component->items['page_title']->id ?>"><?= $component->items['page_title']->label !== null ? $component->items['page_title']->label : $component->items['page_title']->model->getAttributeLabel($component->items['page_title']->attribute); ?></label>
            </div>
            <div class="form-group col-xs-8<?= ($hasError = $component->items['page_title']->model->hasErrors($component->items['page_title']->attribute)) ? ' has-error' : ''; ?>">
                <?php if (! empty($component->items['page_title']->data)): ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['page_title']->type], [$component->items['page_title']->model, $component->items['page_title']->attribute, $component->items['page_title']->data, $component->items['page_title']->options]); ?>
                <?php else: ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['page_title']->type], [$component->items['page_title']->model, $component->items['page_title']->attribute, $component->items['page_title']->options]); ?>
                <?php endif; ?>
                <div class="control-label help-inline"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php foreach($col_1 as $cur): ?>
                    <label for="<?= $component->items[$cur]->id ?>"><?= $component->items[$cur]->label !== null ? $component->items[$cur]->label : $component->items[$cur]->model->getAttributeLabel($component->items[$cur]->attribute); ?></label>
                    <?php if (! empty($component->items[$cur]->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->data, $component->items[$cur]->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <?php foreach($col_2 as $cur): ?>
                    <label for="<?= $component->items[$cur]->id ?>"><?= $component->items[$cur]->label !== null ? $component->items[$cur]->label : $component->items[$cur]->model->getAttributeLabel($component->items[$cur]->attribute); ?></label>
                    <?php if (! empty($component->items[$cur]->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->data, $component->items[$cur]->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                <?php endforeach; ?>
            </div>
        </div>
        <input name="_scenario" type="hidden" value="update_description"/>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
</div>