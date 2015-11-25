<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="treeview active">
                <a href="<?= Url::to(['/']); ?>">
                    <i class="fa fa-dashboard"></i><span><?= Yii::t('kalibao.backend', 'navbar_dashboard'); ?></span></i>
                </a>
            </li>

            <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:medias'])): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th"></i>
                    <span><?= Yii::t('kalibao.backend', 'navbar_media'); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\message\controllers\MessageController'])): ?>
                    <li><a href="<?= Url::to(['/message/message/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_message'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\message\controllers\MessageGroupController'])): ?>
                    <li><a href="<?= Url::to(['/message/message-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_message_group'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\mail\controllers\MailTemplateController'])): ?>
                    <li><a href="<?= Url::to(['/mail/mail-template/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_mail_template'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\mail\controllers\MailTemplateGroupController'])): ?>
                    <li><a href="<?= Url::to(['/mail/mail-template-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_mail_template_group'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:cms'])): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cube"></i> <span><?= Yii::t('kalibao.backend', 'navbar_cms'); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsPageController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-page/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_page'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsLayoutController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-layout/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_layout'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsSimpleMenuGroupController'])): ?>
                        <li><a href="<?= Url::to(['/cms/cms-simple-menu-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_simple_menu_group'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsImageController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-image/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_image'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsImageGroupController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-image-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_image_group'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsWidgetController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-widget/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_widget'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsWidgetGroupController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-widget-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_widget_group'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsNewsController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-news/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_news'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\cms\controllers\CmsNewsGroupController'])): ?>
                    <li><a href="<?= Url::to(['/cms/cms-news-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_cms_news_group'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:products'])): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i> <span><?= Yii::t('kalibao.backend', 'navbar_product'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\product\controllers\ProductController'])): ?>
                            <li><a href="<?= Url::to(['/product/product/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_product_list'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\product\controllers\ProductController'])): ?>
                            <li><a href="<?= Url::to(['/product/product/create']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_product_add'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\brand\controllers\BrandController'])): ?>
                            <li><a href="<?= Url::to(['/brand/brand/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_brand_list'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\supplier\controllers\SupplierController'])): ?>
                            <li><a href="<?= Url::to(['/supplier/supplier/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_supplier_list'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\attribute-type\controllers\AttributeTypeController'])): ?>
                            <li><a href="<?= Url::to(['/attribute-type/attribute-type/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_attribute_list'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:tree'])): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-sitemap"></i> <span><?= Yii::t('kalibao.backend', 'navbar_tree'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\tree\controllers\TreeController'])): ?>
                            <li><a href="<?= Url::to(['/tree/tree/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_tree_list'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:rights'])): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span><?= Yii::t('kalibao.backend', 'navbar_right'); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\rbac\controllers\PersonUserController'])): ?>
                    <li><a href="<?= Url::to(['/rbac/person-user/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_rbac_person_user'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\rbac\controllers\RbacRoleController'])): ?>
                    <li><a href="<?= Url::to(['/rbac/rbac-role/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_rbac_role'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\rbac\controllers\RbacPermissionController'])): ?>
                    <li><a href="<?= Url::to(['/rbac/rbac-permission/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_rbac_permission'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\rbac\controllers\RbacPermissionRoleController'])): ?>
                    <li><a href="<?= Url::to(['/rbac/rbac-permission-role/edit']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_rbac_permission_role'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:customer'])): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user"></i> <span><?= Yii::t('kalibao.backend', 'navbar_customer'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\third\controllers\ThirdController'])): ?>
                            <li><a href="<?= Url::to(['/third/third']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_third'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\third\controllers\ThirdRoleController'])): ?>
                            <li><a href="<?= Url::to(['/third/third-role']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_third_role'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\third\controllers\PersonGenderController'])): ?>
                            <li><a href="<?= Url::to(['/third/person-gender']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_person_gender'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\third\controllers\CompanyTypeController'])): ?>
                            <li><a href="<?= Url::to(['/third/company-type']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_company_type'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\third\controllers\CompanyContactController'])): ?>
                            <li><a href="<?= Url::to(['/third/company-contact']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_company_contact'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\third\controllers\AddressTypeController'])): ?>
                            <li><a href="<?= Url::to(['/third/address-type']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_address_type'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:parameters'])): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cogs"></i> <span><?= Yii::t('kalibao.backend', 'navbar_parameter'); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\language\controllers\LanguageController'])): ?>
                    <li><a href="<?= Url::to(['/language/language/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_language'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\language\controllers\LanguageGroupController'])): ?>
                    <li><a href="<?= Url::to(['/language/language-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_language_group'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\language\controllers\LanguageGroupLanguageController'])): ?>
                    <li><a href="<?= Url::to(['/language/language-group-language/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_language_group_language'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\variable\controllers\VariableController'])): ?>
                    <li><a href="<?= Url::to(['/variable/variable/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_variable'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.consult:*', 'permission.consult:kalibao\backend\modules\variable\controllers\VariableGroupController'])): ?>
                    <li><a href="<?= Url::to(['/variable/variable-group/list']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_variable_group'); ?></a></li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->canMultiple(['permission.update:*', 'permission.update:kalibao\backend\modules\cache\controllers\CacheDbController'])): ?>
                        <li><a href="<?= Url::to(['/cache/cache-db/refresh']); ?>"><i class="fa fa-circle-o"></i> <?= Yii::t('kalibao.backend', 'navbar_db_schema_flush'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>