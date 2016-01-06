<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$this->registerJs("
    new $.kalibao.backend.tree.View({
        id: '".sha1($title)."',
        treeData: ". $json ."
    });
");
?>

<div class="content-block" id="<?= sha1($title) ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <fieldset>
                        <legend>
                            <?= ucfirst($title) ?>&nbsp;
                        </legend>
                        <a class="btn btn-primary btn-xs" id="add-branch"><?= Yii::t('kalibao', 'btn_add'); ?> &nbsp;<i class="fa fa-plus"></i></a>
                        <a class="btn btn-primary btn-xs" id="open-all" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('kalibao.backend', 'label_expand') ?>"><i class="fa fa-expand"></i></a>
                        <a class="btn btn-primary btn-xs" id="close-all" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('kalibao.backend', 'label_collapse') ?>"><i class="fa fa-compress"></i></a>
                        <div id="tree"></div>
                        <a class="btn btn-primary btn-xs" id="save-tree"><?= Yii::t('kalibao', 'btn_save'); ?> &nbsp;<i class="glyphicon glyphicon-floppy-disk"></i></a>
                        <a class="btn btn-default btn-xs" id="reset-tree"><?= Yii::t('kalibao.backend', 'btn_reset') ?> &nbsp;<i class="glyphicon glyphicon-refresh"></i></a>
                    </fieldset>
                </div>
                <div class="col-md-9" id="branch-container"></div>
            </div>
        </section>
    </div>
</div>