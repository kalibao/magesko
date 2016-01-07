<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$img_id = Yii::$app->variable->get('kalibao.backend', 'media_type_picture');
$img_txt = Yii::t('kalibao.backend', 'media_type_picture');
$emb_id = Yii::$app->variable->get('kalibao.backend', 'media_type_embed');
$emb_txt = Yii::t('kalibao.backend', 'media_type_embed');
$doc_id = Yii::$app->variable->get('kalibao.backend', 'media_type_document');
$doc_txt = Yii::t('kalibao.backend', 'media_type_document');

$mediaTypes = $component->models['main']->mediaTypes
?>

<div class="tab-pane" id="media">
    <div class="row">
        <!-- Images -->
        <fieldset class="col-md-6">
            <legend><?= $img_txt ?></legend>
            <?php if (array_key_exists($img_id, $mediaTypes)): ?>
                <?php foreach ($mediaTypes[$img_id][1] as $media): ?>
                    <?= $media->html ?>
                <?php endforeach; ?>
                <?php unset($mediaTypes[$img_id]) ?>
            <?php endif; ?>
            <div class="text-center">
                <button class="btn btn-primary" data-toggle="modal" data-target="#media-image-form"><?= Yii::t('kalibao', 'btn_add') ?></button>
            </div>
        </fieldset>

        <!-- Embed video -->
        <fieldset class="col-md-6">
            <legend><?= $emb_txt ?></legend>
            <?php if (array_key_exists($emb_id, $mediaTypes)): ?>
                <?php foreach ($mediaTypes[$emb_id][1] as $media): ?>
                    <?= $media->embed ?>
                <?php endforeach; ?>
                <?php unset($mediaTypes[$emb_id]) ?>
            <?php endif; ?>
            <div class="text-center">
                <button class="btn btn-primary" data-toggle="modal" data-target="#media-embed-form"><?= Yii::t('kalibao', 'btn_add') ?></button>
            </div>
        </fieldset>

        <!-- Document -->
        <fieldset class="col-md-6">
            <legend><?= $doc_txt ?></legend>
            <?php if (array_key_exists($doc_id, $mediaTypes)): ?>
                <?php foreach ($mediaTypes[$doc_id][1] as $media): ?>
                    <?= $media->html ?>
                <?php endforeach; ?>
                <?php unset($mediaTypes[$doc_id]) ?>
            <?php endif; ?>
            <div class="text-center">
                <button class="btn btn-primary" data-toggle="modal" data-target="#media-document-form"><?= Yii::t('kalibao', 'btn_add') ?></button>
            </div>
        </fieldset>
    </div>
    <?= $this->render('_mediaModal', compact('component')) ?>
</div>