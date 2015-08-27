<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Html;

kalibao\backend\components\web\BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-blue">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <?= $this->render('_header'); ?>
        <?= $this->render('_sideBar'); ?>
        <?= $this->render('_content', ['content' => $content]); ?>
        <?= $this->render('_footer'); ?>
    </div><!-- ./wrapper -->
    <div id="kalibao"></div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
