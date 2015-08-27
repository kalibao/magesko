<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="content">
    <section class="content-header">
        <?php if (isset($success)): ?>
            <div class="callout callout-success">
                <h4><?= Yii::t('kalibao', 'module_generated'); ?></h4>
            </div>
        <?php endif; ?>
        <h1><?= Yii::t('kalibao', 'module_generator_title'); ?></h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'application'); ?>
                    <?= $form->field($model, 'version'); ?>
                    <?= $form->field($model, 'module'); ?>
                    <?= $form->field($model, 'controller'); ?>
                    <?= $form->field($model, 'translateGroup'); ?>
                    <?= $form->field($model, 'table')->dropDownList($tableList); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Validate', ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</div>