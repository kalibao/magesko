<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
use \kalibao\common\components\i18n\I18N;

?>

<div class="tab-pane" id="bundle">
    <div class="text-center form-inline">
        <label><?= Yii::t('kalibao.backend', 'label_variant_select') ?></label>
        <select class="form-control input-sm" id="cross_selling_variation">
            <?php foreach ($component->models['main']->variantList as $v): ?>
                <option value="<?= $v->id ?>">
                    <?php foreach ($v->variantAttributes as $attribute): ?>
                        <?= ($attribute->attributeI18n) ? $attribute->attributeI18n->value : $attribute->attributeI18ns[0]->value ?>
                    <?php endforeach; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <form method="POST" action="<?= \yii\helpers\Url::to(['save-discount'] + ['id' => $component->models['main']->id]) ?>">
        <div id="cross_selling-tables">
            <?php foreach ($component->models['main']->crossSellingInfo as $id => $crossSales): ?>
                <div class="table-responsive cross-selling-table" id="cross_selling_<?= $id ?>">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th class="col-xs-2"><?= Yii::t('kalibao.backend', 'label_product') ?></th>
                            <th><?= Yii::t('kalibao.backend', 'label_price_incl_tax') ?></th>
                            <th><?= Yii::t('kalibao.backend', 'label_price_discount') ?>
                                <span class="pull-right mouse-pointer copy-first-double" data-placement="bottom" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend',
                                    'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                            <th><?= Yii::t('kalibao.backend', 'label_discount_value') ?>
                                <span class="pull-right mouse-pointer copy-first-double" data-placement="bottom" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend',
                                    'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                            <th><?= Yii::t('kalibao.backend', 'label_discount_rate') ?>
                                <span class="pull-right mouse-pointer copy-first-double" data-placement="bottom" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend',
                                    'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                            <th><?= Yii::t('kalibao.backend', 'label_start_date') ?>
                                <span class="pull-right mouse-pointer copy-first-double" data-placement="bottom" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend',
                                    'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                            <th><?= Yii::t('kalibao.backend', 'label_end_date') ?>
                                <span class="pull-right mouse-pointer copy-first-double" data-placement="bottom" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend',
                                    'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                            <th><?= Yii::t('kalibao.backend', 'label_final_price') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($crossSales as $data): ?>
                            <tr class="top-border-bold">
                                <td rowspan="2">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <?= $this->render('../_thumbnail', ['product' => $data['product']]); ?>
                                        </div>
                                        <div class="col-xs-8">
                                            <?= $data['producti18n']->name ?><br/>
                                            <?php foreach ($data['variant2']->variantAttributes as $attribute): ?>
                                                <span class="badge" data-extraCost="<?= $attribute->extra_cost ?>"><?= ($attribute->attributeI18n) ? $attribute->attributeI18n->value : '' ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-5"><?= Yii::t('kalibao.backend', 'label_public') ?></div>
                                        <div class="col-xs-7">
                                            <input class="form-control input-sm pull-right" type="text" disabled value="<?= $data['variant2']->finalPrice ?>"/>
                                        </div>
                                    </div>
                                </td>
                                <td><input class="form-control input-sm discount-price" type="text"/></td>
                                <td><input class="form-control input-sm discount-value" type="text"/></td>
                                <td>
                                    <input class="form-control input-sm discount-rate" type="text" name="discount[<?= $data['discount']->id ?>][percent]" value="<?= $data['discount']->percent ?>"/>
                                </td>
                                <td>
                                    <input class="form-control input-sm date-picker" type="text" name="discount[<?= $data['discount']->id ?>][start_date]" rel="<?= Yii::$app->formatter->asDate($data['discount']->start_date,
                                        I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                                <td>
                                    <input class="form-control input-sm date-picker" type="text" name="discount[<?= $data['discount']->id ?>][end_date]" rel="<?= Yii::$app->formatter->asDate($data['discount']->end_date,
                                        I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                                <td><input class="form-control input-sm discount-final-price" type="text" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-5"><?= Yii::t('kalibao.backend', 'label_private') ?></div>
                                        <div class="col-xs-7">
                                            <input class="form-control input-sm pull-right" type="text" disabled value="<?= $data['variant2']->finalPrice ?>"/>
                                        </div>
                                    </div>
                                </td>
                                <td><input class="form-control input-sm discount-price" type="text"/></td>
                                <td><input class="form-control input-sm discount-value" type="text"/></td>
                                <td>
                                    <input class="form-control input-sm discount-rate" type="text" name="discount[<?= $data['discount']->id ?>][percent_vip]" value="<?= $data['discount']->percent_vip ?>"/>
                                </td>
                                <td>
                                    <input class="form-control input-sm date-picker" type="text" name="discount[<?= $data['discount']->id ?>][start_date_vip]" rel="<?= Yii::$app->formatter->asDate($data['discount']->start_date_vip,
                                        I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                                <td>
                                    <input class="form-control input-sm date-picker" type="text" name="discount[<?= $data['discount']->id ?>][end_date_vip]" rel="<?= Yii::$app->formatter->asDate($data['discount']->end_date_vip,
                                        I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                                <td><input class="form-control input-sm discount-final-price" type="text" disabled/>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-6 col-md-offset-3">
                <input id="variant-selector" placeholder="sélectionner" type="hidden" class="form-control input-sm input-ajax-select" name="variant" data-action="<?= \yii\helpers\Url::to(['/product/product/advanced-drop-down-list'] + ['id' => 'variantList']) ?>">
            </div>
            <div class="col-xs-6">
                <button class="btn btn-primary" id="add-new-cross_sale"><i class="fa fa-plus"></i><?= Yii::t('kalibao',
                        'btn_add') ?></button>
            </div>
        </div>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
</div>