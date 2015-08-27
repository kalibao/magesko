<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$this->title = $crudEdit->title;
?>
<div class="content-dynamic">
    <?= $this->render('crud/edit/_contentBlock', ['crudEdit' => $crudEdit], $this->context); ?>
</div>