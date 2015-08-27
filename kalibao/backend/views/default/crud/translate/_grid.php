<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<table class="table table-bordered table-condensed">
    <?= $this->render('crud/translate/_gridHead', ['crudTranslate' => $crudTranslate], $this->context); ?>
    <?= $this->render('crud/translate/_gridBody', ['crudTranslate' => $crudTranslate], $this->context); ?>
    <?= $this->render('crud/translate/_gridFoot', ['crudTranslate' => $crudTranslate], $this->context); ?>
</table>