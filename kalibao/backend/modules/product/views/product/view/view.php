<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$this->title = !empty($component->models['i18n']->page_title) ? $component->models['i18n']->page_title : $component->models['i18n']->name ;
?>
<div class="content-dynamic">
    <?= $this->render('_contentBlock', compact('component', 'create', 'bundle')); ?>
</div>