<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content crud-list">
    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('crud/list/_actions', ['crudList' => $crudList], $this->context); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('crud/list/_advancedFilters', ['crudList' => $crudList], $this->context); ?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('crud/list/_grid', ['crudList' => $crudList], $this->context); ?>
                </div>
            </div>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('crud/list/_pager', ['crudList' => $crudList], $this->context); ?>
                </div>
            </div>
        </div>
    </div>
</section>