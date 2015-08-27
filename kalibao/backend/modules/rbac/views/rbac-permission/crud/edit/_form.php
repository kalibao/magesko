<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<div class="callout callout-warning">
    <?= Yii::t('kalibao.backend', 'warning_user_rigth_refresh_auto') ?>
</div>
<form method="POST" action="<?= $crudEdit->action; ?>">
    <?= $this->render('crud/edit/_grid', ['crudEdit' => $crudEdit], $this->context); ?>
</form>