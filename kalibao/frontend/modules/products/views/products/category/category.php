<?php
/**
 * @copyright Copyright (c) 2015 - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\cms\CmsPageService;
use kalibao\common\components\helpers\URLify;
use yii\widgets\LinkPager;
?>
<div id="products">
    <?php foreach ($models as $model): ?>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-preview">
                    <h2 class="post-title">
                        <a href="<?= Yii::$app->getUrlManager()->createUrl([$productUrl . URLify::filter($model->productI18ns[0]->name), 'prod' => $model->id]) ?>">
                            <?= $model->productI18ns[0]->name; ?>
                        </a>
                    </h2>
                    <p class="post-subtitle">
                        <?= $model->productI18ns[0]->short_description; ?>
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
</div>

