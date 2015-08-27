<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
use kalibao\common\components\helpers\Html;

?>
<td class="td-inline-actions">
    <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('delete'), 'permission.delete:*'])): ?>
    <div class="form-group">
        <label class="checkbox">
            <?= Html::checkBox('rows[]', false, array('class' => 'check-row', 'id' => false, 'value' => http_build_query($row->getPk()))); ?>
        </label>
    </div>
    <?php endif; ?>

    <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('update'), 'permission.update:*'])): ?>
    <a href="<?= Url::to(['edit-row'] + $row->getPk() + $row->requestParams); ?>" class="btn-edit-row" title="<?= Yii::t('kalibao', 'btn_edit_inline'); ?>">
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    <?php endif; ?>

    <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('delete'), 'permission.delete:*'])): ?>
        <a href="<?= Url::to(['delete-rows'] + $row->getPk() + $row->requestParams); ?>" data-name="rows[]"
           data-value="<?= http_build_query($row->getPk()); ?>" class="btn-delete-row"
           title="<?= Yii::t('kalibao', 'btn_delete'); ?>">
            <span class="glyphicon glyphicon-trash"></span>
        </a>
    <?php endif; ?>
</td>