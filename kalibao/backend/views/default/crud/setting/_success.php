<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<?php if ($crudSetting->isSaved()): ?>
    <div class="callout callout-success">
        <h4><?= Yii::t('kalibao', 'is_saved'); ?></h4>
        <div class="actions-success">
            <a class="btn btn-default btn-close" href="<?= $crudSetting->closeAction; ?>">
                <span><?= Yii::t('kalibao', 'btn_close'); ?></span>
            </a>
        </div>
    </div>
<?php endif; ?>