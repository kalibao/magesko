<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Html;

$this->title = $message;
?>

<?php $this->beginBlock('cms_block_page_1'); ?>
<!-- Page Header --><!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('http://static.kalibaoframework.lan/common/data/cms-image/max/cd83bfd6d1c9e8da56f1d8da4642fc9f/post-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="page-heading">
                    <h1><?= Yii::t('kalibao.frontend', 'Erreur'); ?></h1>
                    <hr class="small" />
                    <span class="subheading"><?= nl2br(Html::encode($message)) ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<?php  $this->endBlock(); ?>