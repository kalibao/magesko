<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<td class="td-inline-actions">
    <a href="<?= Url::to(['edit-row'] + $crudListFieldEdit->getPk() + $crudListFieldEdit->requestParams); ?>" class="btn-update-row" title="<?= Yii::t('kalibao', 'btn_save'); ?>">
        <span class="glyphicon glyphicon-floppy-disk"></span>
    </a>
    <a href="<?= Url::to(['refresh-row'] + $crudListFieldEdit->getPk() + $crudListFieldEdit->requestParams); ?>" class="btn-close-row" title="<?= Yii::t('kalibao', 'btn_cancel'); ?>">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
</td>