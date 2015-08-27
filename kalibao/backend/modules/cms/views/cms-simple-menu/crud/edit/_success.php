<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<?php if ($crudEdit->isSaved()): ?>
    <div class="callout callout-success">
        <h4><?= Yii::t('kalibao', 'is_saved'); ?></h4>
        <div class="actions-success">
            <?php if($crudEdit->models['main'] && $crudEdit->addAgain && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('create'), 'permission.create:*'])): ?>
            <a class="btn-success btn btn-add-again" href="<?= Url::to(['create', 'cms_simple_menu_group_id' => $crudEdit->models['main']->cms_simple_menu_group_id]) ?>">
                <span class="glyphicon glyphicon-plus-sign"></span>
                <span><?= Yii::t('kalibao', 'btn_add_again'); ?></span>
            </a>
            <?php endif; ?>
            <a class="btn btn-default btn-close" href="<?= $crudEdit->closeAction; ?>">
                <span><?= Yii::t('kalibao', 'btn_close'); ?></span>
            </a>
        </div>
    </div>
<?php endif; ?>