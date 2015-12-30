<?php
/**
 * @copyright Copyright (c) 2015 - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\cms\CmsPageService;
use kalibao\common\components\helpers\URLify;
use yii\widgets\LinkPager;

?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <h1><?= $model->productI18ns[0]->name; ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="post-preview">
            <p class="post-subtitle">
                <?= $model->productI18ns[0]->short_description; ?>
            </p>
            <img class="thumbnail col-xs-6" src="<?= $model->thumbnailInfo['url'] ?>"
                 alt="<?= $model->thumbnailInfo['alt']; ?>">
        </div>
        <div class="col-sm-12">
            variations pour cet article :
            <ul>
                <?php foreach ($model->variantList as $variant): ?>
                    <li>

                        <?php foreach ($variant->variantAttributes as $attribute): ?>
                            <span
                                class="badge"><?= ($attribute->attributeI18n) ? $attribute->attributeI18n->value : '' ?></span>
                        <?php endforeach; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>