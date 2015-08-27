<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$this->title = $crudList->title;
?>
<div class="content-dynamic">
    <?= $this->render('crud/list/_contentBlock', ['crudList' => $crudList], $this->context); ?>
</div>