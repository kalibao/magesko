<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content crud-edit">
    <div class="row">
        <div class="col-xs-12">
            <?= $this->render('crud/edit/_success', ['crudEdit' => $crudEdit], $this->context); ?>
            <?= $this->render('crud/edit/_error', ['crudEdit' => $crudEdit], $this->context); ?>
            <?= $this->render('crud/edit/_form', ['crudEdit' => $crudEdit], $this->context); ?>
        </div>
    </div>
</section>