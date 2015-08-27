<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\validators\ClientSideValidator;

$this->registerJs("
    new $.kalibao.backend.crud.Setting({
        id: '".$crudSetting->id."',
        messages: $.extend($.kalibao.core.app.messages, { /* your messages */ })".
    (
        $crudSetting->hasClientValidationEnabled()
        ? ",
            validators: ".json_encode(ClientSideValidator::getClientValidators($crudSetting->items, $this))
        : ""
    )."
    });
");
?>
<div class="content-block" id="<?= $crudSetting->id; ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('crud/setting/_header', ['crudSetting' => $crudSetting], $this->context); ?>
        <?= $this->render('crud/setting/_content', ['crudSetting' => $crudSetting], $this->context); ?>
    </div>
</div>