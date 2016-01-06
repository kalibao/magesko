<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="modal fade" id="media-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-main">
                    <section class="content-header">
                        <a class="btn pull-right description-update" data-dismiss="modal">×</a>
                        <h1><?= Yii::t('kalibao.backend', 'label_media_add') ?></h1>
                    </section>
                    <section class="content">
                        <div class="box box-primary">
                            <div class="box-body text-center">
                                <select class="select-media">
                                    <option data-id="#media-file" value="file">Fichier</option>
                                    <option data-id="#media-url" value="url">URL</option>
                                </select>

                                <!-- media from file -->
                                <div style="display: none;" id="media-file">
                                    <form method="post" action="<?= \yii\helpers\Url::to(['/media/media/create'] + ['product' => $component->models['main']->id]) ?>">
                                        <input type="file" name="Media[file]" id="media-file"  class="input-advanced-uploader center-block"/>
                                        <label><?= Yii::t('kalibao.backend', 'label_media_type_id') ?></label><input type="hidden" class="form-control input-sm input-ajax-select" name="Media[media_type_id]" data-action="/fr/media/media/advanced-drop-down-list?id=media_type_i18n.title" data-add-action="/fr/media/media-type/create" data-placeholder="Sélectionner">
                                        <label><?= Yii::t('kalibao.backend', 'label_media_title') ?></label><input type="text" class="form-control input-sm" name="MediaI18n[title]"/>
                                        <hr/>
                                        <button class="btn btn-primary center-block btn-submit" id="send-media" data-dismiss="modal"><?= yii::t('kalibao', 'btn_save') ?></button>
                                    </form>
                                </div>

                                <!-- media from url -->
                                <div style="display: none;" id="media-url">
                                    <form method="post" action="<?= \yii\helpers\Url::to(['/media/media/from-url'] + ['product' => $component->models['main']->id]) ?>">
                                        <label><?= Yii::t('kalibao.backend', 'label_media_url') ?></label><input type="text" class="form-control input-sm" name="media_url"/>
                                        <div class="checkbox"><label><input type="checkbox" name="media_import"/><?= Yii::t('kalibao.backend', 'label_media_import') ?></label></div>
                                        <label><?= Yii::t('kalibao.backend', 'label_media_title') ?></label><input type="text" class="form-control input-sm" name="media_title"/>
                                        <hr/>
                                        <button class="btn btn-primary center-block btn-submit" id="send-media-url" data-dismiss="modal"><?= yii::t('kalibao', 'btn_save') ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>