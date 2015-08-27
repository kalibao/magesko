<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="content">
    <section class="content-header">
        <h1><?= Yii::t('kalibao', 'module_generator_title'); ?></h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <?php $form = ActiveForm::begin(['action' => ['index']]); ?>
                    <table class="table table-bordered table-hover table-condensed">
                        <tr>
                            <th><?= Yii::t('kalibao', 'generator_position'); ?></th>
                            <th><?= Yii::t('kalibao', 'generator_column'); ?></th>
                            <th><?= Yii::t('kalibao', 'generator_table'); ?></th>
                            <th><?= Yii::t('kalibao', 'generator_type'); ?></th>
                            <th><?= Yii::t('kalibao', 'generator_option'); ?></th>
                            <th><?= Yii::t('kalibao', 'generator_related_column_displayed'); ?></th>
                        </tr>
                        <?php $i = 0; foreach($columns as $column): ?>
                            <tr>
                                <td><?= Html::textInput('position['.$column[0].'.'.$column[1]->name.']', $i); ?></td>
                                <td><?= $column[1]->name; ?></td>
                                <td><?= $column[0]; ?></td>
                                <td><?= $column[1]->phpType; ?></td>
                                <td>
                                    <?=
                                        Html::dropDownList(
                                            'column['.$column[0].'.'.$column[1]->name.']',
                                            null,
                                            $model->getDropDownList($column[1], !empty($tableLinks[$column[1]->name][1]))
                                        );
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if (!empty($tableLinks[$column[1]->name][1])) {
                                            $data = [];
                                            foreach ($tableLinks[$column[1]->name][1] as $columnLink) {
                                                $data[$columnLink[0].'.'.$columnLink[1]->name] = $columnLink[1]->name;
                                            }
                                            echo Html::dropDownList('relation['.$column[0].'.'.$column[1]->name.']', null, $data);
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php $i += 10; endforeach; ?>
                    </table>
                    <div class="form-group">
                        <?= Html::activeHiddenInput($model, 'application'); ?>
                        <?= Html::activeHiddenInput($model, 'controller'); ?>
                        <?= Html::activeHiddenInput($model, 'module'); ?>
                        <?= Html::activeHiddenInput($model, 'table'); ?>
                        <?= Html::activeHiddenInput($model, 'translateGroup'); ?>
                        <?= Html::hiddenInput('build', '1'); ?>
                        <?= Html::submitButton('Validate', ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</div>