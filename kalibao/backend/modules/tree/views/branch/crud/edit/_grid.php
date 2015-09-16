<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<?= $this->render('crud/edit/_gridBody', ['crudEdit' => $crudEdit], $this->context); ?>
<div class="text-center">

    <?= $this->render('crud/edit/_gridFoot', ['crudEdit' => $crudEdit], $this->context); ?>
</div>

<fieldset>
    <legend>Filtres visibles</legend>
    <table class="table text-center">
        <thead>
        <tr>
            <th class="col-xs-5">Attribut</th>
            <th class="col-xs-7">Label</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($crudEdit->models['main']->attributeList as $attr): ?>
            <tr id="attribute-<?= $attr['id']?>" class="saved">
                <td><?= $attr['i18n'] ?> &nbsp; <i class="fa fa-lg fa-trash text-red delete-filter" data-params='{"attribute_type_id":<?= $attr['id'] ?>, "branch_id":<?= $crudEdit->models['main']->id ?>}'></i></td>
                <td><input type="text" class="form-control input-sm" value="<?= (!empty($attr['label']))?$attr['label']:$attr['i18n'] ?>"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" class="form-inline">
                <input id="input-attribute-type" type="hidden" class="form-control input-sm input-ajax-select" name="attribute-type" data-action="<?= \yii\helpers\Url::to(['/attribute-type/attribute-type/advanced-drop-down-list'] + ['id' => 'attribute_type.value']) ?>" data-allow-clear="1" data-placeholder="Sélectionner" data-attribute-url="<?= \yii\helpers\Url::to(['/attribute/attribute/advanced-drop-down-list'] + ['id' => 'attribute.value']) ?>">
                <a class="btn btn-primary btn-sm" id="add-filter"><i class="fa fa-plus"></i> &nbsp;Ajouter</a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a class="btn btn-primary" id="save-filters" data-branch="<?= $crudEdit->models['main']->id ?>"><i class="glyphicon glyphicon-floppy-disk"></i> &nbsp;<?= Yii::t('kalibao', 'btn_save') ?></a>
            </td>
        </tr>
        </tfoot>
    </table>
</fieldset>

