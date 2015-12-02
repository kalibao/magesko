<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
$col_1 = ['name', 'supplier_id', 'brand_id', 'accountant_category_id', 'stats_category_id'];
$col_2 = ['exclude_discount_code', 'force_secure', 'archived', 'alternative_product', 'available_date', 'google_category_id'];
?>

<div class="tab-pane active" id="product">
    <form method="POST" action="<?= $component->action; ?>">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="row">
                    <?php if (!$create): ?>
                        <div class="col-xs-5">
                            <label><?= $component->items['id']->model->getAttributeLabel($component->items['id']->attribute); ?></label>
                        </div>
                        <div class="form-group col-xs-7">
                            <?= $component->items['id']->value ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php foreach($col_1 as $cur): ?>
                    <div class="row">
                        <div class="col-xs-5">
                            <label class="<?= ($component->items[$cur]->required)? "required":"" ?>" for="<?= $component->items[$cur]->id ?>"><?= $component->items[$cur]->label !== null ? $component->items[$cur]->label : $component->items[$cur]->model->getAttributeLabel($component->items[$cur]->attribute); ?></label>
                        </div>
                        <div class="form-group col-xs-7<?= ($hasError = $component->items[$cur]->model->hasErrors($component->items[$cur]->attribute)) ? ' has-error' : ''; ?>">
                            <?php if (! empty($component->items[$cur]->data)): ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->data, $component->items[$cur]->options]); ?>
                            <?php else: ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->options]); ?>
                            <?php endif; ?>
                            <div class="control-label help-inline"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-xs-12 col-md-6">
                <?php foreach($col_2 as $cur): ?>
                    <div class="row">
                        <div class="col-xs-5">
                            <label class="<?= ($component->items[$cur]->required)? "required":"" ?>" for="<?= $component->items[$cur]->id ?>"><?= $component->items[$cur]->label !== null ? $component->items[$cur]->label : $component->items[$cur]->model->getAttributeLabel($component->items[$cur]->attribute); ?></label>
                        </div>
                        <div class="form-group col-xs-7<?= ($hasError = $component->items[$cur]->model->hasErrors($component->items[$cur]->attribute)) ? ' has-error' : ''; ?>">
                            <?php if (! empty($component->items[$cur]->data)): ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->data, $component->items[$cur]->options]); ?>
                            <?php else: ?>
                                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items[$cur]->type], [$component->items[$cur]->model, $component->items[$cur]->attribute, $component->items[$cur]->options]); ?>
                            <?php endif; ?>
                            <div class="control-label help-inline"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if ($create): ?>
            <input type="hidden" class="form-control input-sm required" name="Product[base_price]" value="0" />
        <?php endif; ?>
        <input name="_scenario" type="hidden" value="update_product"/>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
</div>