<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$this->title = $crudEdit->title;
?>
<div class="content-dynamic">
    <?= $this->render('crud/create/_contentBlock', ['crudEdit' => $crudEdit], $this->context); ?>
</div>