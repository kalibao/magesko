<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
$tree = ($component->tree['json'] === null)?json_encode([]):$component->tree['json'];

$this->registerJs("
    new $.kalibao.backend.product.View({
        id: '".$component->id."',
        treeData: ". $tree.",
        categories: ". $component->models['main']->getCategories(true) .",
        messages: $.extend($.kalibao.core.app.messages, { /* your messages */ })".
    (
    $component->hasClientValidationEnabled()
        ? ",
            validators: ".json_encode(\kalibao\common\components\validators\ClientSideValidator::getClientValidators($component->items, $this))
        : ""
    )."
    });
");
?>

<div class="content-block" id="<?= $component->id; ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('_header', compact('component', 'create')); ?>
        <?= $this->render('_body', compact('component', 'create')); ?>
    </div>
</div>