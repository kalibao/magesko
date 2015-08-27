<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\helpers\Html;
?>
<tfoot>
    <tr>
        <td colspan="2" class="text-center">
            <?= Html::activeHiddenInput($crudEdit->models['main'], 'cms_simple_menu_group_id'); ?>
            <?php
            if (($crudEdit->models['main']->isNewRecord && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('create'), 'permission.create:*'])) ||
                (!$crudEdit->models['main']->isNewRecord && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('update'), 'permission.update:*']))):
            ?>
                <button class="btn btn-primary btn-submit">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    <span><?= Yii::t('kalibao', 'btn_save'); ?></span>
                </button>
            <?php endif; ?>
            <a href="<?= $crudEdit->closeAction; ?>" class="btn btn-default btn-close">
                <span><?= Yii::t('kalibao', 'btn_close'); ?></span>
            </a>
        </td>
    </tr>
</tfoot>
