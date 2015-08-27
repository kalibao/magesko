<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\validators\ClientSideValidator;

$this->registerJs("
    new $.kalibao.crud.Edit({
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
        <?= $this->render('crud/edit/_header', ['crudEdit' => $crudEdit], $this->context); ?>
        <?= $this->render('crud/edit/_content', ['crudEdit' => $crudEdit], $this->context); ?>
    </div>
</div>