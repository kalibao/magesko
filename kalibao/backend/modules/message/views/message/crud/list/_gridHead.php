<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<thead>
    <?= $this->render('crud/list/_gridHeadTitles', ['crudList' => $crudList], $this->context); ?>
    <?= $this->render('crud/list/_gridHeadFilters', ['crudList' => $crudList], $this->context); ?>
</thead>