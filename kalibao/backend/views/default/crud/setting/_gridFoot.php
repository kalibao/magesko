<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<tfoot>
    <tr>
        <td colspan="2" class="text-center">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam?>" value="<?= Yii::$app->request->csrfToken?>" />
            <button class="btn btn-primary btn-submit">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                <span><?= Yii::t('kalibao', 'btn_save'); ?></span>
            </button>
            <a href="<?= $crudSetting->closeAction; ?>" class="btn btn-default btn-close">
                <span><?= Yii::t('kalibao', 'btn_close'); ?></span>
            </a>
        </td>
    </tr>
</tfoot>
