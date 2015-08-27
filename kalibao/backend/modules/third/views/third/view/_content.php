<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content">
    <?= $this->render('view/information/_informations', compact($listCompact, 'listCompact'), $this->context); ?>
    <?= $this->render('view/tab/_tab', compact($listCompact, 'listCompact'), $this->context); ?>
</section>