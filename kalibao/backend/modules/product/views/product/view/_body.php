<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

?>
<section class="content">
    <div class="nav-tabs-custom">
        <?php if ($create): ?>
            <?= $this->render('_tabsCreate', compact('bundle')); ?>
            <div class="tab-content">
                <?= $this->render('tabs/_product', compact('component', 'create', 'bundle')); ?>
            </div>
        <?php else : ?>
        <?= $this->render('_tabs', compact('bundle')); ?>
        <div class="tab-content">
            <?= $this->render('tabs/_product', compact('component', 'create')); ?>
            <?= $this->render('tabs/_attribute', compact('component')); ?>
            <?= $this->render('tabs/_variantList', compact('component')); ?>
            <?= $this->render('tabs/_variantGenerator', compact('component')); ?>
            <?= $this->render('tabs/_description', compact('component')); ?>
            <?= $this->render('tabs/_prices', compact('component')); ?>
            <?= $this->render('tabs/_catalog', compact('component')); ?>
            <?= $this->render('tabs/_logistic', compact('component')); ?>
            <?= $this->render('tabs/_crossSelling', compact('component')); ?>
            <?= $this->render('tabs/_discount', compact('component')); ?>
            <?= $this->render('tabs/_media', compact('component')); ?>
            <?php if($bundle): ?>
                <?= $this->render('tabs/_bundle', compact('component')); ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
