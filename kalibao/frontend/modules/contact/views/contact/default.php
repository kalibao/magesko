<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kalibao\common\components\helpers\Html;
?>

<?php if ($success): ?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="alert alert-success" role="alert">
            <strong><?= Yii::t('kalibao.frontend', 'email_is_sent'); ?></strong>
        </div>
    </div>
</div>
<?php endif ?>

<?php if ($hasError): ?>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <div class="alert alert-danger" role="alert">
                <strong><?= Yii::t('kalibao.frontend', 'email_not_sent'); ?></strong>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if (isset($this->blocks['cms_block_page_2'])): ?>
    <?= $this->blocks['cms_block_page_2']; ?>
<?php endif; ?>


<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <?php $form = ActiveForm::begin(['id' => 'contact-form']) ?>
        <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <?=
                    $form->field($model, 'name')->textInput([
                        'placeholder' => $model->getAttributeLabel('name'),
                        'class' => 'form-control'
                    ]);
                ?>
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <?=
                    $form->field($model, 'email')->textInput([
                        'placeholder' => $model->getAttributeLabel('email'),
                        'class' => 'form-control'
                    ]);
                ?>
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <?=
                    $form->field($model, 'phone')->textInput([
                        'placeholder' => $model->getAttributeLabel('phone'),
                        'class' => 'form-control'
                    ]);
                ?>
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <?=
                    $form->field($model, 'message')->textarea([
                        'placeholder' => $model->getAttributeLabel('message'),
                        'class' => 'form-control'
                    ]);
                ?>
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <br />
        <div class="row control-group">
            <?=
                $form->field($model, 'verify_code')->widget(Captcha::className(), [
                    'captchaAction' => '/contact/captcha',
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-3">{input}</div></div>',
                ])
            ?>
        </div>
        <br>
        <div class="row">
            <div class="form-group col-xs-12">
                <?= Html::submitButton(Yii::t('kalibao', 'btn_send'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>