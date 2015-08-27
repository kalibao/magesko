<?php
use yii\widgets\LinkPager;
?>

<?php foreach ($models as $model): ?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="post-preview">
            <h2 class="post-title">
                <?= $model->cmsNewsI18ns[0]->title; ?>
            </h2>
            <p class="post-subtitle">
                <?= $model->cmsNewsI18ns[0]->content; ?>
            </p>
            <p class="post-meta"></p>
        </div>
        <hr>
    </div>
</div>
<?php endforeach ?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <?=
            LinkPager::widget([
                'pagination' => $pages,
                'options' => [
                    'class' => 'pagination pagination-sm no-margin pull-left'
                ],
            ]);
        ?>
    </div>
</div>