<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
$modals = '';
?>

<div class="tab-pane" id="variant-list">
    <form method="POST" action="<?= \yii\helpers\Url::to(['save-variant'] + ['id' => $component->models['main']->id]) ?>">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th><?= Yii::t('kalibao.backend', 'label_variant') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_code') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_order') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_supplier_code') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_ean13_code') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_visible') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_main') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_top_selling') ?></th>
                        <th><?= Yii::t('kalibao.backend', 'label_variant_description') ?></th>
                        <th><?= Yii::t('kalibao', 'btn_delete') ?></th>
                    </tr>
                </thead>
                <tbody class="sortable">
                    <?php $i=1; foreach($component->models['main']->variantList as $variant): ?>
                        <tr>
                            <td>
                                <?php foreach ($variant->variantAttributes as $attribute): ?>
                                    <span class="badge"><?= ($attribute->attributeI18n)?$attribute->attributeI18n->value:'' ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td><input value="<?= empty($variant->code)?$variant->id:$variant->code ?>" name="variant[<?= $variant->id ?>][code]" class="form-control input-sm" type="text"/></td>
                            <td><span class="sort-handle badge"><i class="fa fa-arrows"></i></span><input disabled value="<?= empty($variant->order)?$i++:$variant->order ?>" name="variant[<?= $variant->id ?>][order]" class="form-control input-sm variant-order" type="text"/></td>
                            <td><input value="<?= $variant->supplier_code ?>" name="variant[<?= $variant->id ?>][supplier_code]" class="form-control input-sm" type="text"/></td>
                            <td><input value="<?= $variant->barcode ?>" name="variant[<?= $variant->id ?>][barcode]" class="form-control input-sm" type="text"/></td>
                            <td class="form-inline"><div class="checkbox"><label><input <?= $variant->visible ? 'checked': '' ?>  name="variant[<?= $variant->id ?>][visible]" type="checkbox"/></label></div></td>
                            <td class="form-inline"><div class="checkbox"><label><input <?= $variant->primary ? 'checked': '' ?>  name="variant[<?= $variant->id ?>][primary]" type="radio"/></label></div></td>
                            <td class="form-inline"><div class="checkbox"><label><input <?= $variant->top_selling ? 'checked': '' ?>  name="variant[<?= $variant->id ?>][top_selling]" type="checkbox"/></label></div></td>
                            <td>
                                <textarea class="form-control input-sm hidden" id="description-<?= $variant->id ?>" name="variant[<?= $variant->id ?>][description]" ><?= ($variant->variantI18n)?$variant->variantI18n->description:'' ?></textarea>
                                <i class="btn fa fa-2x fa-pencil" data-toggle="modal" data-target="#description-popup-<?= $variant->id ?>"></i>
                                <?php ob_start(); ?>
                                    <?= $this->render('_variantListModal', compact('variant')) ?>
                                <?php $modals .= ob_get_clean(); ?>
                            </td>
                            <td>
                                <i class="btn fa fa-2x fa-trash text-red delete-variant" data-id="<?= $variant->id ?>"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <a class="btn btn-primary pull-right" href="#attribute" data-toggle="tab">
                    <span><?= Yii::t('kalibao.backend', 'product_tab_attribute'); ?></span>
                </a>
            </div>
            <div class="col-xs-6">
                <a class="btn btn-primary" href="#variant-generator" data-toggle="tab">
                    <span><?= Yii::t('kalibao.backend', 'product_tab_variant_generator') ?></span>
                </a>
            </div>
        </div>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
    <?= $modals ?>
</div>