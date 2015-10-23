<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>

<div class="tab-pane" id="catalog">
    <form method="POST" action="<?= $component->action; ?>">
        <div class="row">
            <div class="col-md-6">
                <label for="<?= $component->items['link_brand_product']->id ?>"><?= $component->items['link_brand_product']->label !== null ? $component->items['link_brand_product']->label : $component->items['link_brand_product']->model->getAttributeLabel($component->items['link_brand_product']->attribute); ?></label>
                <?php if (! empty($component->items['link_brand_product']->data)): ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['link_brand_product']->type], [$component->items['link_brand_product']->model, $component->items['link_brand_product']->attribute, $component->items['link_brand_product']->data, $component->items['link_brand_product']->options]); ?>
                <?php else: ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['link_brand_product']->type], [$component->items['link_brand_product']->model, $component->items['link_brand_product']->attribute, $component->items['link_brand_product']->options]); ?>
                <?php endif; ?>
                <br>
                <label for="<?= $component->items['link_product_test']->id ?>"><?= $component->items['link_product_test']->label !== null ? $component->items['link_product_test']->label : $component->items['link_product_test']->model->getAttributeLabel($component->items['link_product_test']->attribute); ?></label>
                <?php if (! empty($component->items['link_product_test']->data)): ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['link_product_test']->type], [$component->items['link_product_test']->model, $component->items['link_product_test']->attribute, $component->items['link_product_test']->data, $component->items['link_product_test']->options]); ?>
                <?php else: ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $component->items['link_product_test']->type], [$component->items['link_product_test']->model, $component->items['link_product_test']->attribute, $component->items['link_product_test']->options]); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <fieldset>
                    <legend><?= $component->tree['title'] ?></legend>
                    <div id="tree"></div>
                </fieldset>
            </div>
        </div>

        <?= $this->render('../_buttons', ['propagation' => false]) ?>
    </form>
</div>