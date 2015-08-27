<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<td class="td-action">
    <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('update'), 'permission.update:*'])): ?>
    <a href="<?= Url::to(['update'] + $row->getPk()); ?>" class="btn btn-sm btn-default btn-update" title="<?= Yii::t('kalibao', 'btn_update'); ?>">
        <span class="glyphicon glyphicon-pencil"></span>
    </a>
    <?php endif; ?>
    <?php if ($row->isTranslatable() && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('translate'), 'permission.translate:*'])): ?>
    <a href="<?= Url::to(['translate'] + $row->getPk()); ?>" class="btn btn-sm btn-default btn-translate" title="<?= Yii::t('kalibao', 'btn_translate'); ?>">
        <span class="glyphicon glyphicon-globe"></span>
    </a>
    <?php endif; ?>
    <?php if (isset($row->requestParams['mode']) && $row->requestParams['mode'] == 'explorer' && isset($row->requestParams['CKEditorFuncNum'])): ?>
        <a href="#" class="btn btn-sm btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $row->requestParams['CKEditorFuncNum']; ?>, '<?= $row->uploadConfig[(new \ReflectionClass($row->model))->getParentClass()->name]['file_path']['baseUrl'].'/min/'.$row->items['file_path']; ?>', ''); window.close(); return false;">
            <?= Yii::t('kalibao.backend', 'btn_cms_image_select_sm'); ?>
        </a>
        <a href="#" class="btn btn-sm btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $row->requestParams['CKEditorFuncNum']; ?>, '<?= $row->uploadConfig[(new \ReflectionClass($row->model))->getParentClass()->name]['file_path']['baseUrl'].'/max/'.$row->items['file_path']; ?>', ''); window.close(); return false;">
            <?= Yii::t('kalibao.backend', 'btn_cms_image_select_lg'); ?>
        </a>
    <?php endif; ?>
</td>