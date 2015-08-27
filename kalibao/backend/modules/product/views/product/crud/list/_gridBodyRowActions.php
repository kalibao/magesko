<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<td class="td-action">
    <a href="<?= Url::to(['view'] + $row->getPk()); ?>" class="btn btn-sm btn-default btn-view" title="<?= Yii::t('kalibao', 'btn_view'); ?>">
        <span class="glyphicon glyphicon-edit"></span>
    </a>
    <?php if ($row->isTranslatable() && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('translate'), 'permission.translate:*'])): ?>
    <a href="<?= Url::to(['translate'] + $row->getPk()); ?>" class="btn btn-sm btn-default btn-translate" title="<?= Yii::t('kalibao', 'btn_translate'); ?>">
        <span class="glyphicon glyphicon-globe"></span>
    </a>
    <?php endif; ?>
</td>