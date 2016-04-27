<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
use kalibao\common\components\helpers\Html;
?>
<td class="td-inline-actions">
    <?php if (Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('delete'), 'permission.delete:*'])): ?>
        <div class="form-group">
            <label class="checkbox">
                <?= Html::checkBox('rows[]', false, array('class' => 'check-row', 'id' => false, 'value' => http_build_query($crudListFieldEdit->getPk()))); ?>
            </label>
        </div>
        <a href="<?= Url::to(['delete-rows'] + $crudListFieldEdit->getPk() + $crudListFieldEdit->requestParams); ?>" data-name="rows[]"
           data-value="<?= http_build_query($crudListFieldEdit->getPk()); ?>" class="btn-delete-row"
           title="<?= Yii::t('kalibao', 'btn_delete'); ?>">
            <span class="glyphicon glyphicon-trash"></span>
        </a>
    <?php endif; ?>
</td>