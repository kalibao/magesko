<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="row">
    <?php if ((Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('update'), 'permission.update:*']))): ?>
        <div class="col-xs-6">
            <button class="btn btn-primary btn-submit pull-right">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                <span><?= Yii::t('kalibao', 'btn_save'); ?></span>
            </button>
        </div>
        <div class="col-xs-6">
            <button class="btn btn-warning reset-form">
                <span class="glyphicon glyphicon-refresh"></span>
                <span><?= Yii::t('kalibao.backend', 'btn_reset') ?></span>
            </button>
        </div>
    <?php endif; ?>
</div>

