<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<header class="main-header">
<!-- Logo -->
<span class="logo"><i class="fa fa-cloud"></i> <?= Yii::$app->name;  ?></span>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>
<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
<ul class="nav navbar-nav">
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="hidden-xs">
            <?= Yii::$app->user->identity->first_name ?>
            <?= Yii::$app->user->identity->last_name ?>
        </span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <p>
                <?= Yii::t('kalibao.backend', 'select_other_language') ?>
            </p>
            <?= \kalibao\backend\components\web\LanguageMenuWidget::widget(); ?>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="<?= Url::to(['/profile/profile/update']) ?>" class="btn btn-default btn-flat ajax-link">
                    <?= Yii::t('kalibao.backend', 'navbar_profile'); ?>
                </a>
            </div>
            <div class="pull-right">
                <a href="<?= Url::to(['/authentication/authentication/logout']) ?>" class="btn btn-default btn-flat">
                    <?= Yii::t('kalibao.backend', 'navbar_logout'); ?>
                </a>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</nav>
</header>