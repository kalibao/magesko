<?php
/**
 * @copyright Copyright (c) 2015 - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<tfoot>
<tr>
    <td colspan="2" class="text-center">
        <?php
        if (($crudEdit->models['main']->isNewRecord && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('create'), 'permission.create:*'])) ||
            (!$crudEdit->models['main']->isNewRecord && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('update'), 'permission.update:*']))):
            ?>
            <button class="btn btn-primary btn-submit">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                <span><?= Yii::t('kalibao', 'btn_save'); ?></span>
            </button>
        <?php endif; ?>
        <a class="btn btn-default btn-close"><?= Yii::t('kalibao', 'btn_close'); ?></a>
    </td>
</tr>
</tfoot>