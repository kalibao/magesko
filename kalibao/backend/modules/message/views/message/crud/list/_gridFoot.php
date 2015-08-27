<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<tfoot>
    <tr>
        <td colspan="<?= count($crudList->gridHeadAttributes) + 2; ?>">
            <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('translate'), 'permission.translate:*'])): ?>
            <a href="#" class="check-all">
                <span class="glyphicon glyphicon-check"></span>
                <span><?= Yii::t('kalibao', 'btn_check_all'); ?></span>
            </a>
            <span>|</span>
            <a href="#" class="uncheck-all">
                <span class="glyphicon glyphicon-unchecked"></span>
                <span><?= Yii::t('kalibao', 'btn_uncheck_all'); ?></span>
            </a>
            <span class="glyphicon glyphicon-chevron-right"></span>
            <a href="<?= Url::to([$this->context->id.'/delete-rows'] + $crudList->requestParams); ?>" class="btn-delete-all">
                <span class="glyphicon glyphicon-trash"></span>
                <span><?= Yii::t('kalibao', 'btn_delete_selected'); ?></span>
            </a>
            <?php endif; ?>
        </td>
    </tr>
</tfoot>