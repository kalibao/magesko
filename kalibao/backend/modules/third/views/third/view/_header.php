<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info box-solid">
                <div class="box-header">
                    <h1 class="box-title text-bold">
                        <?php if ($isPerson) {
                            echo $crudEdit->models['person']->first_name . ' ' . $crudEdit->models['person']->last_name;
                        } else {
                            echo $crudEdit->models['company']->name;
                        } ?>
                    </h1>
                    <div class="box-tools pull-right">
                        <a class="btn btn-close" href="<?= $crudEdit->closeAction; ?>"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <a href="<?= \yii\helpers\Url::to(['/third/company-contact/create']); ?>"class="btn btn-primary btn-is-society">
                <span class="fa fa-building"></span>
                <span><?= Yii::t('kalibao.backend', 'btn_add_society') ?></span>
            </a>
        </div>
        <div class="col-xs-6">
            <div class="pull-right">
            <a href="<?= \yii\helpers\Url::to(['/third/premium/create']); ?>" class="btn btn-primary btn-generate-premium disabled">
                <span class="fa fa-star"></span>
                <span><?= Yii::t('kalibao.backend', 'btn_generate_premium'); ?></span>
            </a>
            </div>
        </div>
    </div>
</section>

