<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="tab-pane" id="attribute">
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
                <tr>
                    <th><?= Yii::t('kalibao.backend', 'label_attributes') ?></th>
                    <th><?= Yii::t('kalibao.backend', 'label_attributes_value') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($component->models['main']->attributeInfo as $attributeType => $datas): ?>
                    <tr id="attr-type-<?= reset($datas)['typeId'] ?>" data-id="<?= reset($datas)['typeId'] ?>">
                        <td>
                            <?= $attributeType ?>
                        </td>
                        <td>
                        <?php foreach($datas as $data): ?>
                            <span class="badge" id="attr-<?= $data['id'] ?>" data-id="<?= $data['id'] ?>">
                                <?= $data['value'] ?>
                            </span>
                        <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="row text-center">
        <button class="btn btn-danger" id="refresh-variants"><i class="glyphicon glyphicon-refresh"></i> &nbsp; <?= Yii::t('kalibao.backend', 'btn_refresh') ?></button>
        <button class="btn btn-danger" id="save-attributes"><i class="glyphicon glyphicon-floppy-disk"></i> &nbsp; <?= Yii::t('kalibao', 'btn_save') ?></button>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <a class="btn btn-primary pull-right" href="#variant-list" data-toggle="tab">
                <span><?= Yii::t('kalibao.backend', 'product_tab_variant_list'); ?></span>
            </a>
        </div>
        <div class="col-xs-6">
            <a class="btn btn-primary" href="#variant-generator" data-toggle="tab">
                <span><?= Yii::t('kalibao.backend', 'product_tab_variant_generator') ?></span>
            </a>
        </div>
    </div>
</div>