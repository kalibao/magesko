<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\widgets\ActiveForm;
use kalibao\common\components\helpers\Html;
?>
<div class="login-box">
    <div class="login-logo">
        <b>Kalibao</b> / Backend
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= $form->field($model, 'username') ?>
                </div>
                <div class="col-xs-12">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'remember_me')->checkbox() ?>
                </div>
                <div class="col-xs-4">
                    <div class="form-group text-right">
                        <?= Html::submitButton(Yii::t('kalibao', 'login_btn_connect'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div><!-- /.login-box-body -->
</div>
