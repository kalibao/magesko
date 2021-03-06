<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

?>

<ul class="nav nav-tabs">
    <li><a href="#product" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_product') ?></a></li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <?= Yii::t('kalibao.backend', 'product_tab_attribute') ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="#attribute" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_attribute') ?></a></li>
            <li class="divider"></li>
            <li><a href="#variant-list" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_variant_list') ?></a></li>
            <li><a href="#variant-price" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_variant_price') ?></a></li>
        </ul>
    </li>
    <li><a href="#description" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_description') ?></a></li>
    <li><a href="#prices" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_prices') ?></a></li>
    <li><a href="#logistic" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_logistic') ?></a></li>
    <li><a href="#cross_selling" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_cross_selling') ?></a></li>
    <li><a href="#discount" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_discount') ?></a></li>
    <li><a href="#media" data-toggle="tab"><?= Yii::t('kalibao.backend', 'product_tab_media') ?></a></li>
</ul>