<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

?>

<div class="tab-pane" id="variant-price">
    <form method="POST" action="<?= \yii\helpers\Url::to(['save-variant-price'] + ['id' => $component->models['main']->id]) ?>">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                <tr>
                    <th><?= Yii::t('kalibao.backend', 'label_attributes') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_attributes_value') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_attribute_overcost') ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($component->models['main']->attributeInfo as $attributeType => $datas): ?>
                        <?php foreach($datas as $data): ?>
                            <tr>
                                <td><?= $attributeType ?></td>
                                <td>
                                    <span class="badge"><?= $data['value'] ?></span>
                                </td>
                                <td><input name="attribute[<?= $data['id'] ?>][extra_cost]" type="text" class="form-control input-sm" value="<?= empty($data['price'])?0:$data['price'] ?>"/></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <a class="btn btn-primary pull-right" href="#variant-list" data-toggle="tab">
                    <span><?= Yii::t('kalibao.backend', 'product_tab_variant_list'); ?></span>
                </a>
            </div>
            <div class="col-xs-6">
                <a class="btn btn-primary" href="#attribute" data-toggle="tab">
                    <span><?= Yii::t('kalibao.backend', 'product_tab_attribute') ?></span>
                </a>
            </div>
        </div>
        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
</div>