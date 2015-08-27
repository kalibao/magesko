<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<td class="td-action" style="width:120px">
    <a href="<?= Url::to(['view'] + $row->getPk()); ?>" class="btn btn-sm btn-default btn-view" title="<?= Yii::t('kalibao', 'btn_view'); ?>">
        <span class="glyphicon glyphicon-eye-open"></span>
    </a>
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
</td>