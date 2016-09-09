<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
$tree = ($component->tree['json'] === null) ? json_encode([]) : $component->tree['json'];

$this->registerJs("
    new $.kalibao.backend.product.View({
        id: '" . $component->id . "',
        treeData: " . $tree . ",
        categories: " . $component->models['main']->getCategories(true) . ",
        messages: $.extend($.kalibao.core.app.messages, {
            'btnClose': '"             . Yii::t('kalibao', 'btn_close') . "',
            'btnDelete': '"            . Yii::t('kalibao', 'btn_delete') . "',
            'uploadDropFile': '"       . Yii::t('kalibao.backend', 'upload_drop_file') . "',
            'uploadSelectFile': '"     . Yii::t('kalibao.backend', 'upload_select_file') . "',
            'toastSavedText': '"       . Yii::t('kalibao.backend', 'toast_saved_text') . "',
            'toastFileUploaded': '"    . Yii::t('kalibao.backend', 'toast_file_uploaded') . "',
            'toastUploadComplete': '"  . Yii::t('kalibao.backend', 'toast_upload_complete') . "',
            'toastFileDeleted': '"     . Yii::t('kalibao.backend', 'toast_file_deleted') . "',
            'toastSavedTitle': '"      . Yii::t('kalibao.backend', 'toast_saved_title') . "',
            'toastErrorTitle': '"      . Yii::t('kalibao.backend', 'toast_error_title') . "',
            'toastUnsavedText': '"     . Yii::t('kalibao.backend', 'toast_unsaved_text') . "',
            'toastUnsavedTitle': '"    . Yii::t('kalibao.backend', 'toast_unsaved_title') . "',
            'toastValidationText': '"  . Yii::t('kalibao.backend', 'toast_validation_text') . "',
            'toastValidationTitle': '" . Yii::t('kalibao.backend', 'toast_validation_title') . "',
            'variantConfirmDelete': '" . Yii::t('kalibao.backend', 'variant_confirm_delete') . "',
        })" .
    (
    $component->hasClientValidationEnabled()
        ? ",
            validators: " . json_encode(\kalibao\common\components\validators\ClientSideValidator::getClientValidators($component->items,
            $this))
        : ""
    ) . "
    });
");
?>

<div class="content-block" id="<?= $component->id; ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <?= $this->render('_header', compact('component', 'create', 'bundle')); ?>
        <?= $this->render('_body', compact('component', 'create', 'bundle')); ?>
    </div>
</div>