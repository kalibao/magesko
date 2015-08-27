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
            <a href="<?= Url::to(['create', 'mail_template_id' => $crudList->model->mail_template_id]); ?>" class="btn btn-sm btn-danger btn-create">
                <span class="glyphicon glyphicon-plus-sign"></span>
                <b><?= Yii::t('kalibao', 'btn_add'); ?></b>
            </a>
        <?php endif; ?>
    </div>
</div>