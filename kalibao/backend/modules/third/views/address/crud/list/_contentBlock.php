<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\validators\ClientSideValidator;

$this->registerJs("
    new $.kalibao.backend.client.AddressList({
        id: '".$crudList->id."',
        messages: $.extend($.kalibao.core.app.messages, { /* your messages */ })".
    (
        $crudList->hasClientValidationEnabled()
        ? ",
            gridHeadFiltersValidators: ".json_encode(ClientSideValidator::getClientValidators($crudList->gridHeadFilters, $this)).",
            advancedFiltersValidators: ".json_encode(ClientSideValidator::getClientValidators($crudList->advancedFilters, $this))
        : ""
    )."
    });
");
?>
<div class="content-block" id="<?= $crudList->id; ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('crud/list/_header', ['crudList' => $crudList], $this->context); ?>
        <?= $this->render('crud/list/_content', ['crudList' => $crudList], $this->context); ?>
    </div>
</div>