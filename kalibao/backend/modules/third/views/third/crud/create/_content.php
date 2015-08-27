<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content crud-edit">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('crud/create/_success', ['crudEdit' => $crudEdit], $this->context); ?>
                    <?= $this->render('crud/create/_error', ['crudEdit' => $crudEdit], $this->context); ?>
                    <?= $this->render('crud/create/_form', ['crudEdit' => $crudEdit], $this->context); ?>
                </div>
            </div>
        </div>
    </div>
</section>