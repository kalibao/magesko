<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="tab-pane" id="media">
    <div class="row">
        <?php foreach($component->models['main']->mediaTypes as $type => $medias): ?>
            <fieldset class="col-md-6">
                <legend><?= $type ?></legend>
                <?php foreach ($medias as $media): ?>
                    <?= $media->html ?>
                <?php endforeach; ?>
            </fieldset>
        <?php endforeach; ?>
    </div>
    <div class="clearfix"></div>
    <div class="text-center">
        <button class="btn btn-primary" data-toggle="modal" data-target="#media-form"><?= Yii::t('kalibao', 'btn_add') ?></button>
    </div>
    <?= $this->render('_mediaModal', compact('component')) ?>
</div>