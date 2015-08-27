<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<td class="td-action">
    <?php if (Yii::$app->user->canMultiple(['permission.consult:kalibao\backend\modules\cms\controllers\CmsSimpleMenuGroup', 'permission.consult:*'])): ?>
        <a href="<?= Url::to(['cms-simple-menu/list', 'ModelFilter[cms_simple_menu_group_id]' => $row->getPk()['id']]); ?>" class="btn btn-sm btn-default btn-list-menu" title="<?= Yii::t('kalibao.backend', 'btn_cms_simple_menu'); ?>">
            <span class="glyphicon glyphicon-list-alt"></span>
        </a>
    <?php endif; ?>
    <?php if ($row->isTranslatable() && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('translate'), 'permission.translate:*'])): ?>
    <a href="<?= Url::to(['translate'] + $row->getPk()); ?>" class="btn btn-sm btn-default btn-translate" title="<?= Yii::t('kalibao', 'btn_translate'); ?>">
        <span class="glyphicon glyphicon-globe"></span>
    </a>
    <?php endif; ?>
</td>