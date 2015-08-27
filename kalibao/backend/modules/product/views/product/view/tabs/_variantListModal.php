<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<div class="modal fade" id="description-popup-<?= $variant->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-main">
                    <section class="content-header">
                        <a class="btn pull-right description-update" data-dismiss="modal">×</a>
                        <h1><?= Yii::t('kalibao', 'btn_add') ?></h1>
                    </section>
                    <section class="content">
                        <div class="box box-primary">
                            <div class="box-body">
                                <textarea class="form-control input-sm wysiwyg-textarea" data-origin="#description-<?= $variant->id ?>"><?= ($variant->variantI18n)?$variant->variantI18n->description:'' ?></textarea>
                                <button class="btn btn-primary center-block description-update" data-dismiss="modal"><?= Yii::t('kalibao', 'btn_save') ?></button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>