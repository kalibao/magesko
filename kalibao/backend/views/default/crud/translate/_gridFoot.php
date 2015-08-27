<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<tfoot>
    <tr>
        <td colspan="<?= count($crudTranslate->languages) + 1; ?>" class="text-center">
            <button class="btn btn-primary btn-submit">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                <span><?= Yii::t('kalibao', 'btn_save'); ?></span>
            </button>
            <a href="<?= $crudTranslate->closeAction; ?>" class="btn btn-default btn-close">
                <span><?= Yii::t('kalibao', 'btn_close'); ?></span>
            </a>
        </td>
    </tr>
</tfoot>
