<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<table class="table table-bordered table-condensed">
    <?= $this->render('crud/create/_gridBody', ['crudEdit' => $crudEdit], $this->context); ?>
    <?= $this->render('crud/create/_gridFoot', ['crudEdit' => $crudEdit], $this->context); ?>
</table>