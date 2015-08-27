<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<table class="table table-bordered table-condensed">
    <?= $this->render('crud/setting/_gridBody', ['crudSetting' => $crudSetting], $this->context); ?>
    <?= $this->render('crud/setting/_gridFoot', ['crudSetting' => $crudSetting], $this->context); ?>
</table>