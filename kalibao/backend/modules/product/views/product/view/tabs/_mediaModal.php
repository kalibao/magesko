<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="modal fade" id="media-image-form" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <div class="dropzone" id="dropzone"><div class="centered">Déposez vos fichiers ou cliquez pour parcourir</div></div>
                                    <button class="btn btn-primary center-block btn-submit" id="send-media"><?= yii::t('kalibao', 'btn_save') ?></button>
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

<div class="modal fade" id="media-embed-form" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <div id="media-url">
                                    <form method="post" action="<?= \yii\helpers\Url::to(['/media/media/embed'] + ['product' => $component->models['main']->id]) ?>">
                                        <label><?= Yii::t('kalibao.backend', 'label_media_url') ?> (Youtube, Dailymotion, Vimeo)</label><input type="text" class="form-control input-sm" name="media_url"/>
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

<div class="modal fade" id="media-document-form" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <div id="media-file">
                                    <form method="post" action="<?= \yii\helpers\Url::to(['/media/media/create'] + ['product' => $component->models['main']->id]) ?>">
                                        <input type="file" name="Media[file]" id="media-file"  class="input-advanced-uploader center-block"/>
                                        <input type="hidden" name="Media[media_type_id]" value="<?= Yii::$app->variable->get('kalibao.backend', 'media_type_document'); ?>">
                                        <label><?= Yii::t('kalibao.backend', 'label_media_title') ?></label><input type="text" class="form-control input-sm" name="MediaI18n[title]"/>
                                        <hr/>
                                        <button class="btn btn-primary center-block btn-submit" id="send-media" data-dismiss="modal"><?= yii::t('kalibao', 'btn_save') ?></button>
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