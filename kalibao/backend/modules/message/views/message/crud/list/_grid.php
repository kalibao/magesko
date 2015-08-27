<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<?php if ($crudList->saved): ?>
    <div class="callout callout-success">
        <h4><?= Yii::t('kalibao', 'is_saved'); ?></h4>
    </div>
<?php endif; ?>
<div class="table-responsive">
    <table class="list-grid table table-bordered table-hover table-condensed">
        <?= $this->render('crud/list/_gridHead', ['crudList' => $crudList], $this->context); ?>
        <?= $this->render('crud/list/_gridBody', ['crudList' => $crudList], $this->context); ?>
        <?= $this->render('crud/list/_gridFoot', ['crudList' => $crudList], $this->context); ?>
    </table>
</div>