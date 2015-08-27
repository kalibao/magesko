<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$this->title = $crudEdit->title;
?>
<div class="content-dynamic">
    <?= $this->render('view/_contentBlock', compact($listCompact, 'listCompact'), $this->context); ?>
</div>