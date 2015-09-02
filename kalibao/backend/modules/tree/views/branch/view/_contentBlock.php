<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="content-block" id="<?= sha1($title) ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <section class="content">
            <fieldset>
                <legend><?= $title ?></legend>
                <div class="row form-inline">
                    <div class="col-sm-2">
                        <b><?= Yii::t('kalibao.backend', 'branch_visible')?> : </b><input type="checkbox" disabled <?= ($branch->visible)?'selected':'' ?>/>
                    </div>
                    <div class="col-sm-5">
                        <b><?= Yii::t('kalibao.backend', 'branch_label')?> : </b><input type="text" class="form-control" disabled value="<?= $branch->branchI18ns[0]->label ?>" />
                    </div>
                    <div class="col-sm-5">
                        <b><?= Yii::t('kalibao.backend', 'branch_type_label')?> : </b><input type="text" class="form-control" disabled value="<?= $branch->branchTypeI18ns[0]->label ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <b><?= Yii::t('kalibao.backend', 'branch_description') ?> : </b>
                        <div class="textarea"><?= $branch->branchI18ns[0]->description ?></div>
                    </div>
                </div>
                <div class="row center-block">
                    <b><?= Yii::t('kalibao.backend', 'branch_media') ?> : </b><?= $branch->fileTag ?>
                </div>
            </fieldset>
        </section>
    </div>
</div>