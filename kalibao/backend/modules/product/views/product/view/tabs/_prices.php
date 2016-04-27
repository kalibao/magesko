<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

?>

<div class="tab-pane" id="prices">
    <form method="POST" action="<?= $component->action; ?>">
        <div class="row col-xs-12">
            <div class="pull-right"><label><?= Yii::t('kalibao.backend', 'label_show_margin') ?>&nbsp;<input type="checkbox" id="margin-data" class="nocheck"/></label></div>
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
                            <tr>
                                <td><span class="label label-primary"><?= Yii::t('kalibao.backend', 'label_price_all') ?></span></td>
                                <td>
                                    <input class="form-control input-sm" tabindex="1" type="number" name="buyPrice" id="buyPrice"/>
                                </td>
                                <td></td>
                            </tr>
                            <?php foreach($component->models['main']->variantList as $variant): ?>
                                <tr>
                                    <td>
                                        <?php foreach ($variant->variantAttributes as $attribute): ?>
                                            <span class="badge" data-extraCost="<?= $attribute->extra_cost ?>"><?= ($attribute->attributeI18n)?$attribute->attributeI18n->value:'' ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><input class="form-control input-sm" value="<?= $variant->buy_price ?>" type="text" name="Variant[<?= $variant->id ?>][buy_price]"/></td>
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
                            <tr>
                                <td><span class="label label-primary"><?= Yii::t('kalibao.backend', 'label_price_all') ?></span></td>
                                <td>
                                    <input class="form-control input-sm" tabindex="2" type="number" name="priceHT" id="priceHT" data-vat="0.2" data-precision="<?= Yii::$app->variable->get('kalibao.backend', 'price_decimals_count') ?>"/>
                                </td>
                                <td>
                                    <input class="form-control input-sm" tabindex="3" type="number" name="priceTTC" id="priceTTC" data-vat="0.2" data-precision="<?= Yii::$app->variable->get('kalibao.backend', 'price_decimals_count') ?>"/>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php foreach($component->models['main']->variantList as $variant): ?>
                                <tr>
                                    <td>
                                        <?php foreach ($variant->variantAttributes as $attribute): ?>
                                            <span class="badge"><?= ($attribute->attributeI18n)?$attribute->attributeI18n->value:'' ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><input class="form-control input-sm" name="Variant[<?= $variant->id ?>][sell_price]" value="<?= $variant->sell_price ?>" type="text"/></td>
                                    <td><input class="form-control input-sm" type="text"/></td>
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