<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\validators\ClientSideValidator;

$this->registerJs("
    new $.kalibao.backend.third.ThirdEdit({
        id: '".$crudEdit->id."',
        messages: $.extend($.kalibao.core.app.messages, { /* your messages */ })".
    (
        $crudEdit->hasClientValidationEnabled()
        ? ",
            validators: ".json_encode(ClientSideValidator::getClientValidators($crudEdit->items, $this))
        : ""
    )."
    });
");
?>
<div class="content-block" id="<?= $crudEdit->id; ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('view/_header', compact($listCompact, 'listCompact'), $this->context); ?>
        <?= $this->render('view/_content', compact($listCompact, 'listCompact'), $this->context); ?>
    </div>
</div>
<?php var_dump($listCompact); ?>