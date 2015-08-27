<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\validators\ClientSideValidator;

$this->registerJs("
    new $.kalibao.backend.cms.CmsPageTranslate({
        id: '".$crudTranslate->id."',
        messages: $.extend($.kalibao.core.app.messages, { /* your messages */ })".
    (
        $crudTranslate->hasClientValidationEnabled()
        ? ",
            validators: ".json_encode(ClientSideValidator::getClientValidators($crudTranslate->items, $this))
        : ""
    )."
    });
");
?>
<div class="content-block" id="<?= $crudTranslate->id; ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('crud/translate/_header', ['crudTranslate' => $crudTranslate], $this->context); ?>
        <?= $this->render('crud/translate/_content', ['crudTranslate' => $crudTranslate], $this->context); ?>
    </div>
</div>