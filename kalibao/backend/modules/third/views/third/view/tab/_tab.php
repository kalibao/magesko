<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 11/05/15
 * Time: 15:40
 */
?>
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#Address" data-toggle="tab"><?= Yii::t('kalibao.backend', 'address_tab') ?></a></li>
                <li><a href="#Finance" data-toggle="tab"><?= Yii::t('kalibao.backend', 'finance_tab') ?></a></li>

                    <li><a href="#Premium" data-toggle="tab"><?= Yii::t('kalibao.backend', 'premium_tab') ?></a></li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?= Yii::t('kalibao.backend', 'society_tab') ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#Society"><?= Yii::t('kalibao.backend', 'Society_list') ?></a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#Contact"><?= Yii::t('kalibao.backend', 'contact_tab') ?></a></li>
                    </ul>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="Address" data-href="<?= \yii\helpers\Url::to(['/third/address/list'] + ['ModelFilter[third_id]' => $crudEdit->models['main']->id]) ?>">
                    if you see this, please refresh...
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="Finance" data-href="">
                    //TODO
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="Premium" data-href="">
                    //TODO
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="Society" data-href="">
                    //TODO
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="Contact">
                    //TODO Contact
                </div><!-- /.tab-pane -->

            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->
    </div>
</div>