<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

?>

<div class="tab-pane" id="logistic">
    <form action="<?= \yii\helpers\Url::to(['save-variant-logistic'] + ['id' => $component->models['main']->id]) ?>" method="post">
        <div class="table-responsive">
            <table class="table text-center" id="logistic-table">
                <thead>
                <tr>
                    <th><?= Yii::t('kalibao.backend', 'label_variant_code') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_variant') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_stock_strategy') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_stock') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_size_type') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_length') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_width') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_height') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_weight') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($component->models['main']->logisticStrategy as $variant): ?>
                    <tr>
                        <td><?= $variant->code ?></td>
                        <td>
                            <?php foreach ($variant->variantAttributes as $attribute): ?>
                                <span class="badge"><?= ($attribute->attributeI18n)?$attribute->attributeI18n->value:'' ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <i class="mouse-pointer fa fa-2x fa-pencil" data-toggle="modal" data-target="#logistic-popup-<?= $variant->logistic_strategy_id ?>"></i>
                            <?= $this->render('_logisticModal', compact('variant')) ?>
                        </td>
                        <td>&bull;</td>
                        <td><input type="hidden" class="form-control input-sm input-ajax-select"/></td>
                        <td><input value="<?= $variant->length ?>" name="variant[<?= $variant->id ?>][length]" class="form-control input-sm" type="text"/></td>
                        <td><input value="<?= $variant->width ?>" name="variant[<?= $variant->id ?>][width]" class="form-control input-sm" type="text"/></td>
                        <td><input value="<?= $variant->height ?>" name="variant[<?= $variant->id ?>][height]" class="form-control input-sm" type="text"/></td>
                        <td><input value="<?= $variant->weight ?>" name="variant[<?= $variant->id ?>][weight]" class="form-control input-sm" type="text"/></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
</div>