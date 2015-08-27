<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<section class="content-header">
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <?php if ($create): ?>
                    <div class="col-xs-12">
                        <h4 class="box-title"><?= Yii::t('kalibao.backend', 'label_create_product') ?></h4>
                    </div>
                <?php else : ?>
                    <div class="col-lg-1 col-xs-3">
                        <?= $this->render('_thumbnail', ['product' => $component->models['main']]); ?>
                    </div>
                    <div class="col-lg-11 col-xs-9">
                        <h4 class="box-title"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<?= $component->models['i18n']->name ?></h4>
                        <?= Yii::t('kalibao.backend', 'product_variant_count', ['n' => count($component->models['main']->variantList)]) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>