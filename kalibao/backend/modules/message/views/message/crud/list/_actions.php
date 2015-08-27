<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<div class="actions">
    <div class="pull-left">
        <form class="form-inline form-group-language" type="GET" action="<?= Url::to(['list']) ?>">
            <label class="control-label"><?= Yii::t('kalibao', 'select_group_language'); ?> :</label>
            <select class="form-control" name="language_group_id">
                <?php foreach ($crudList->languagesGroups as $languageGroup): ?>
                    <option value="<?= $languageGroup->language_group_id ?>" <?= $languageGroup->language_group_id == $crudList->languageGroupId ? 'selected':'' ?>><?= $languageGroup->title ?></option>
                <?php endforeach ?>
            </select>
        </form>
    </div>
    <div class="pull-right">
        <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('translate'), 'permission.translate:*'])): ?>
            <a href="<?= Url::to(['create', 'language_group_id' => $crudList->languageGroupId]); ?>" class="btn btn-sm btn-danger btn-create">
                <span class="glyphicon glyphicon-plus-sign"></span>
                <b><?= Yii::t('kalibao', 'btn_add'); ?></b>
            </a>
        <?php endif; ?>
        <a href="#" class="btn btn-default btn-sm btn-advanced-filters">
            <span class="glyphicon glyphicon-search"></span>
            <span><?= Yii::t('kalibao', 'btn_advanced_search'); ?></span>
        </a>
        <a href="<?= Url::to(['settings']); ?>" class="btn btn-default btn-sm btn-settings">
            <span class="glyphicon glyphicon-wrench"></span>
            <span><?= Yii::t('kalibao', 'btn_settings'); ?></span>
        </a>
    </div>
</div>