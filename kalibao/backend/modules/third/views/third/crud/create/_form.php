<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<form method="POST" action="<?= $crudEdit->action; ?>">
    <?= $this->render('crud/create/_grid', ['crudEdit' => $crudEdit], $this->context); ?>
</form>