<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

?>
<section class="content">
    <div class="nav-tabs-custom">
        <?php if ($create): ?>
            <?= $this->render('_tabsCreate'); ?>
            <div class="tab-content">
                <?= $this->render('tabs/_product', compact('component', 'create')); ?>
            </div>
        <?php else : ?>
        <?= $this->render('_tabs'); ?>
        <div class="tab-content">
            <?= $this->render('tabs/_product', compact('component', 'create')); ?>
            <?= $this->render('tabs/_attribute', compact('component')); ?>
            <?= $this->render('tabs/_variantList', compact('component')); ?>
            <?= $this->render('tabs/_variantPrice', compact('component')); ?>
            <?= $this->render('tabs/_description', compact('component')); ?>
            <?= $this->render('tabs/_prices', compact('component')); ?>
            <?= $this->render('tabs/_logistic', compact('component')); ?>
            <?= $this->render('tabs/_crossSelling', compact('component')); ?>
            <?= $this->render('tabs/_discount', compact('component')); ?>
            <?= $this->render('tabs/_media', compact('component')); ?>
        </div>
        <?php endif; ?>
    </div>
</section>
