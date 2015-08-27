<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\validators\ClientSideValidator;

$this->registerJs("
    new $.kalibao.backend.third.ThirdList({
        id: '".$crudList->id."',
        messages: $.extend($.kalibao.core.app.messages, {
            modal_create_third: '".Yii::t('kalibao.backend', 'third:modal_create_third')."',
            modal_select_person: '".Yii::t('kalibao.backend', 'third:modal_select_person')."',
            modal_select_company: '".Yii::t('kalibao.backend', 'third:modal_select_company')."',
            })".
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
    <div class="redirect-third"
         data-person="<?= \yii\helpers\Url::to(['create-third'] + ['interface' => \kalibao\common\models\third\Third::PERSON_INTERFACE])?>"
         data-company="<?= \yii\helpers\Url::to(['create-third'] + ['interface' => \kalibao\common\models\third\Third::COMPANY_INTERFACE])?>"></div>
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('crud/list/_header', ['crudList' => $crudList], $this->context); ?>
        <?= $this->render('crud/list/_content', ['crudList' => $crudList], $this->context); ?>
    </div>
</div>