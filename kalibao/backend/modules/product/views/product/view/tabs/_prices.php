<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

?>

<div class="tab-pane" id="prices">
    <form method="POST" action="<?= $component->action; ?>">
        <div class="text-center form-inline">
            <label class="required" for="<?= $component->items['base_price']->id ?>"><?= $component->items['base_price']->label !== null ? $component->items['base_price']->label : $component->items['base_price']->model->getAttributeLabel($component->items['base_price']->attribute); ?></label>
            <?php if (! empty($component->items['base_price']->data)): ?>
                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['base_price']->type], [$component->items['base_price']->model, $component->items['base_price']->attribute, $component->items['base_price']->data, $component->items['base_price']->options]); ?>
            <?php else: ?>
                <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['base_price']->type], [$component->items['base_price']->model, $component->items['base_price']->attribute, $component->items['base_price']->options]); ?>
            <?php endif; ?>
            <label for="priceTTC"><?= Yii::t('kalibao.backend', 'label_price_incl_tax') ?></label>&nbsp;<input class="form-control input-sm" type="text" name="priceTTC" id="priceTTC" data-vat="0.2"/>&nbsp;&nbsp;
            <div class="pull-right"><label><?= Yii::t('kalibao.backend', 'label_show_margin') ?>&nbsp;<input type="checkbox" id="margin-data"/></label></div>
        </div>
        <div class="row">
            <fieldset class="col-md-4">
                <legend><?= Yii::t('kalibao.backend', 'label_buy_price') ?></legend>
                <div class="table-responsive">
                    <table class="table text-center" id="buy-prices-table">
                        <thead>
                            <tr>
                                <th><?= Yii::t('kalibao.backend', 'label_variant') ?></th>
                                <th><?= Yii::t('kalibao.backend', 'label_buy_price') ?></th>
                                <th><?= Yii::t('kalibao.backend', 'label_CMUP') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($component->models['main']->variantList as $variant): ?>
                                <tr>
                                    <td>
                                        <?php foreach ($variant->variantAttributes as $attribute): ?>
                                            <span class="badge" data-extraCost="<?= $attribute->extra_cost ?>"><?= ($attribute->attributeI18n)?$attribute->attributeI18n->value:'' ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><input class="form-control input-sm" type="text"/></td>
                                    <td><input class="form-control input-sm" type="text" disabled/></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <fieldset class="col-md-8">
                <legend><?= Yii::t('kalibao.backend', 'label_sell_price') ?></legend>
                <div class="table-responsive">
                    <table class="table text-center" id="sell-prices-table">
                        <thead>
                            <tr>
                                <th><?= Yii::t('kalibao.backend', 'label_variant') ?></th>
                                <th><?= Yii::t('kalibao.backend', 'label_price_excl_tax') ?></th>
                                <th><?= Yii::t('kalibao.backend', 'label_price_incl_tax') ?></th>
                                <th class="margin-data"  style="display:none"><?= Yii::t('kalibao.backend', 'label_margin_coefficient') ?></th>
                                <th class="margin-data"  style="display:none"><?= Yii::t('kalibao.backend', 'label_margin_rate') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($component->models['main']->variantList as $variant): ?>
                                <tr>
                                    <td>
                                        <?php foreach ($variant->variantAttributes as $attribute): ?>
                                            <span class="badge" data-extraCost="<?= $attribute->extra_cost ?>"><?= ($attribute->attributeI18n)?$attribute->attributeI18n->value:'' ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><input class="form-control input-sm" type="text" disabled/></td>
                                    <td><input class="form-control input-sm" type="text" disabled/></td>
                                    <td><input class="form-control input-sm margin-data" type="text" disabled style="display:none"/></td>
                                    <td><input class="form-control input-sm margin-data" type="text" disabled style="display:none"/></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
        </div>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
        <input name="_scenario" type="hidden" value="update_price"/>
    </form>
</div>