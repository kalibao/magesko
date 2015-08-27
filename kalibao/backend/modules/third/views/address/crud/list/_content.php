<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content crud-list">
    <div class="row">
        <div class="col-xs-12">
            <?= $this->render('crud/list/_actions', ['crudList' => $crudList], $this->context); ?>
        </div>
        <div class="col-xs-12 margin">
            <?= $this->render('crud/list/_advancedFilters', ['crudList' => $crudList], $this->context); ?>
        </div>
        <div class="col-xs-12">
            <?= $this->render('crud/list/_grid', ['crudList' => $crudList], $this->context); ?>
        </div>
        <div class="col-xs-12">
            <?= $this->render('crud/list/_pager', ['crudList' => $crudList], $this->context); ?>
        </div>
    </div>
</section>