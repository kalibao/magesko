<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content crud-setting">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('crud/setting/_success', ['crudSetting' => $crudSetting], $this->context); ?>
                    <?= $this->render('crud/setting/_error', ['crudSetting' => $crudSetting], $this->context); ?>
                    <?= $this->render('crud/setting/_form', ['crudSetting' => $crudSetting], $this->context); ?>
                </div>
            </div>
        </div>
    </div>
</section>