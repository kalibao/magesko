<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<div class="table-responsive">
    <table class="table table-bordered table-condensed">
        <?= $this->render('_gridHead', ['models' => $models]); ?>
        <?= $this->render('_gridBody', ['models' => $models]); ?>
    </table>
    <div class="text-center">
        <a class="btn btn-primary btn-submit" href="#">
            <span class="glyphicon glyphicon-floppy-disk"></span>
            <span><?= Yii::t('kalibao', 'btn_save') ?></span>
        </a>
    </div>
</div>