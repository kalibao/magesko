<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<div class="actions">
    <div class="pull-right">
        <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('create'), 'permission.create:*'])): ?>
            <a href="<?= Url::to(['create', 'cms_simple_menu_group_id' => $crudList->requestParams['ModelFilter']['cms_simple_menu_group_id']]); ?>" class="btn btn-sm btn-danger btn-create">
                <span class="glyphicon glyphicon-plus-sign"></span>
                <b><?= Yii::t('kalibao', 'btn_add'); ?></b>
            </a>
        <?php endif; ?>
        <a href="<?= Url::to(['export'] + $crudList->requestParams); ?>" class="btn btn-default btn-sm btn-export">
            <i class="icon-download-alt"></i>
            <span class="glyphicon glyphicon-download-alt"></span>
            <span><?= Yii::t('kalibao', 'btn_export_csv'); ?></span>
        </a>
    </div>
</div>