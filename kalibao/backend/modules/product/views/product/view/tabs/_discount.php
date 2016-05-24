<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
use \kalibao\common\components\i18n\I18N;
?>

<div class="tab-pane" id="discount">
    <form method="POST" action="<?= \yii\helpers\Url::to(['save-discount'] + ['id' => $component->models['main']->id]) ?>">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                <tr>
                    <th class="col-xs-2"><?= Yii::t('kalibao.backend', 'label_variant') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_price_incl_tax') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_discount_price') ?><span class="pull-right mouse-pointer copy-first-double" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend', 'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                    <th><?= Yii::t('kalibao.backend', 'label_discount_value') ?><span class="pull-right mouse-pointer copy-first-double" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend', 'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                    <th><?= Yii::t('kalibao.backend', 'label_discount_rate') ?><span class="pull-right mouse-pointer copy-first-double" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend', 'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                    <th><?= Yii::t('kalibao.backend', 'label_start_date') ?><span class="pull-right mouse-pointer copy-first-double" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend', 'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                    <th><?= Yii::t('kalibao.backend', 'label_end_date') ?><span class="pull-right mouse-pointer copy-first-double" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend', 'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                    <th><?= Yii::t('kalibao.backend', 'label_final_price') ?><span class="pull-right mouse-pointer" data-toggle="tooltip" title="<?= Yii::t('kalibao.backend', 'label_copy_line') ?>"><i class="fa fa-files-o"></i></span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($component->models['main']->variantList as $variant): ?>
                    <tr class="top-border-bold">
                        <td rowspan="2">
                            <?php foreach ($variant->variantAttributes as $attribute): ?>
                                <span class="badge"><?= ($attribute->attributeI18n)?$attribute->attributeI18n->value:'' ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-xs-5"><?= Yii::t('kalibao.backend', 'label_public') ?></div>
                                <div class="col-xs-7"><input class="form-control input-sm pull-right" type="text" disabled value="<?= $variant->finalPrice ?>"/></div>
                            </div>
                        </td>
                        <td><input class="form-control input-sm discount-price" type="text"/></td>
                        <td><input class="form-control input-sm discount-value" type="text"/></td>
                        <td><input class="form-control input-sm discount-rate" type="text" name="discount[<?= $variant->discount->id ?>][percent]" value="<?= $variant->discount->percent ?>"/></td>
                        <td><input class="form-control input-sm date-picker" type="text" name="discount[<?= $variant->discount->id ?>][start_date]" rel="<?= Yii::$app->formatter->asDate($variant->discount->start_date, I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                        <td><input class="form-control input-sm date-picker" data-error-text="<?= Yii::t('kalibao.backend', 'error_too_small_end_date') ?>" type="text" name="discount[<?= $variant->discount->id ?>][end_date]" rel="<?= Yii::$app->formatter->asDate($variant->discount->end_date, I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                        <td><input class="form-control input-sm discount-final-price" type="text" disabled/></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-xs-5"><?= Yii::t('kalibao.backend', 'label_private') ?></div>
                                <div class="col-xs-7"><input class="form-control input-sm pull-right" type="text" disabled value="<?= $variant->finalPrice ?>"/></div>
                            </div>
                        </td>
                        <td><input class="form-control input-sm discount-price" type="text"/></td>
                        <td><input class="form-control input-sm discount-value" type="text"/></td>
                        <td><input class="form-control input-sm discount-rate" type="text" name="discount[<?= $variant->discount->id ?>][percent_vip]" value="<?= $variant->discount->percent_vip ?>"/></td>
                        <td><input class="form-control input-sm date-picker" type="text" name="discount[<?= $variant->discount->id ?>][start_date_vip]" rel="<?= Yii::$app->formatter->asDate($variant->discount->start_date_vip, I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                        <td><input class="form-control input-sm date-picker" data-error-text="<?= Yii::t('kalibao.backend', 'error_too_small_end_date') ?>" type="text" name="discount[<?= $variant->discount->id ?>][end_date_vip]" rel="<?= Yii::$app->formatter->asDate($variant->discount->end_date_vip, I18N::getDateFormat(I18N::DATE_FORMAT, 'datepicker')) ?>"/></td>
                        <td><input class="form-control input-sm discount-final-price" type="text" disabled/></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
</div>