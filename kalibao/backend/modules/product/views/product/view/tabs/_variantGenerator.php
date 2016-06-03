<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="tab-pane" id="variant-generator">
    <div class="panel panel-info">
        <div class="panel-heading"><?= Yii::t('kalibao.backend', 'help_box') ?></div>
        <div class="panel-body"><?= Yii::t('kalibao.backend', 'variant_generator_help_text') ?></div>
    </div>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#generator_step1" aria-expanded="true" aria-controls="collapseOne">
                        <?= Yii::t('kalibao.backend', 'variant_generator_step1') ?>
                    </a>
                </h4>
            </div>
            <div id="generator_step1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <?= \kalibao\common\models\attribute\Attribute::getSelect(true, 'generator-attributes'); ?>
                    <div class="text-center">
                        <a class="btn btn-primary" id="generate-combinations"><?= Yii::t('kalibao.backend', 'variant_generator_combination') ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo" disabled>
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#generator_step2" aria-expanded="false" aria-controls="collapseTwo">
                        <?= Yii::t('kalibao.backend', 'variant_generator_step2') ?>
                    </a>
                </h4>
            </div>
            <div id="generator_step2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <a class="btn btn-primary" id="generate-variants"><?= Yii::t('kalibao.backend', 'variant_generator_variants') ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <a class="btn btn-primary pull-right" href="#attribute" data-toggle="tab">
                <span><?= Yii::t('kalibao.backend', 'product_tab_attribute'); ?></span>
            </a>
        </div>
        <div class="col-xs-6">
            <a class="btn btn-primary" href="#variant-list" data-toggle="tab">
                <span><?= Yii::t('kalibao.backend', 'product_tab_variant_list'); ?></span>
            </a>
        </div>
    </div>
</div>