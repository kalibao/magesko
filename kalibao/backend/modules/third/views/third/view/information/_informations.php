<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 11/05/15
 * Time: 10:47
 */
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('kalibao.backend', 'information_box') ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body" id="info-box">
                <div class="row">
                    <?php if (isset($crudAddress)) : ?>
                    <div class="col-sm-6">
                    <?php else : ?>
                    <div class="col-sm-12">
                    <?php endif ; ?>
                        <?= $this->render('view/information/_information_form', compact($listCompact, 'listCompact'), $this->context); ?>
                    </div>
                    <?php if (isset($crudAddress)) : ?>
                    <div class="col-sm-6">
                        <?= $this->render('view/information/_information_form_address', compact($listCompact, 'listCompact'), $this->context); ?>
                    </div>
                    <?php endif ; ?>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>