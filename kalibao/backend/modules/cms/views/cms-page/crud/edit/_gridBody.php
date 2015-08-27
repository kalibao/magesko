<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\SimpleValueField;
?>
<tbody>
    <?php if (isset($crudEdit->items['id'])): ?>
    <tr class="<?= $crudEdit->items['id']->attribute ?>">
        <th><?= $crudEdit->items['id']->label !== null ? $crudEdit->items['id']->label : $crudEdit->items['id']->model->getAttributeLabel($crudEdit->items['id']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['id'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['id']->model->hasErrors($crudEdit->items['id']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['id']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['id']->type], [$crudEdit->items['id']->model, $crudEdit->items['id']->attribute, $crudEdit->items['id']->data, $crudEdit->items['id']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['id']->type], [$crudEdit->items['id']->model, $crudEdit->items['id']->attribute, $crudEdit->items['id']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['id'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['id']->start->type], [$crudEdit->items['id']->start->model, $crudEdit->items['id']->start->attribute, $crudEdit->items['id']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['id']->end->type], [$crudEdit->items['id']->end->model, $crudEdit->items['id']->end->attribute, $crudEdit->items['id']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['id'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['id']->value; ?>
            <?php endif; ?>
        </td>
    </tr>
    <?php endif; ?>

    <tr class="<?= $crudEdit->items['title']->attribute ?>">
        <th><?= $crudEdit->items['title']->label !== null ? $crudEdit->items['title']->label : $crudEdit->items['title']->model->getAttributeLabel($crudEdit->items['title']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['title'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['title']->model->hasErrors($crudEdit->items['title']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['id']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['title']->type], [$crudEdit->items['title']->model, $crudEdit->items['title']->attribute, $crudEdit->items['title']->data, $crudEdit->items['title']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['title']->type], [$crudEdit->items['title']->model, $crudEdit->items['title']->attribute, $crudEdit->items['title']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['title'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['title']->start->type], [$crudEdit->items['title']->start->model, $crudEdit->items['title']->start->attribute, $crudEdit->items['title']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['title']->end->type], [$crudEdit->items['title']->end->model, $crudEdit->items['title']->end->attribute, $crudEdit->items['title']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['title'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['title']->value; ?>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="<?= $crudEdit->items['activated']->attribute ?>">
        <th><?= $crudEdit->items['activated']->label !== null ? $crudEdit->items['activated']->label : $crudEdit->items['activated']->model->getAttributeLabel($crudEdit->items['activated']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['activated'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['activated']->model->hasErrors($crudEdit->items['activated']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['activated']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['activated']->type], [$crudEdit->items['activated']->model, $crudEdit->items['activated']->attribute, $crudEdit->items['activated']->data, $crudEdit->items['activated']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['activated']->type], [$crudEdit->items['activated']->model, $crudEdit->items['activated']->attribute, $crudEdit->items['activated']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['activated'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['activated']->start->type], [$crudEdit->items['activated']->start->model, $crudEdit->items['activated']->start->attribute, $crudEdit->items['activated']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['activated']->end->type], [$crudEdit->items['activated']->end->model, $crudEdit->items['activated']->end->attribute, $crudEdit->items['activated']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['activated'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['activated']->value; ?>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="<?= $crudEdit->items['cache_duration']->attribute ?>">
        <th><?= $crudEdit->items['cache_duration']->label !== null ? $crudEdit->items['cache_duration']->label : $crudEdit->items['cache_duration']->model->getAttributeLabel($crudEdit->items['cache_duration']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['cache_duration'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['cache_duration']->model->hasErrors($crudEdit->items['cache_duration']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['activated']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cache_duration']->type], [$crudEdit->items['cache_duration']->model, $crudEdit->items['cache_duration']->attribute, $crudEdit->items['cache_duration']->data, $crudEdit->items['cache_duration']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cache_duration']->type], [$crudEdit->items['cache_duration']->model, $crudEdit->items['cache_duration']->attribute, $crudEdit->items['cache_duration']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['cache_duration'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cache_duration']->start->type], [$crudEdit->items['cache_duration']->start->model, $crudEdit->items['cache_duration']->start->attribute, $crudEdit->items['cache_duration']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cache_duration']->end->type], [$crudEdit->items['cache_duration']->end->model, $crudEdit->items['cache_duration']->end->attribute, $crudEdit->items['cache_duration']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['cache_duration'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['cache_duration']->value; ?>
            <?php endif; ?>
            <?php if (isset($crudEdit->items['id']) && Yii::$app->user->canMultiple([$this->context->getActionControllerPermission('update'), 'permission.update:*'])): ?>
                <a href="<?= Url::to(['refresh-page', 'id' => $crudEdit->items['id']->value]); ?>" class="btn btn-sm btn-default btn-refresh">
                    <?= Yii::t('kalibao.backend', 'btn_refresh_cms_page'); ?>
                </a>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="<?= $crudEdit->items['cms_layout_id']->attribute ?>">
        <th><?= $crudEdit->items['cms_layout_id']->label !== null ? $crudEdit->items['cms_layout_id']->label : $crudEdit->items['cms_layout_id']->model->getAttributeLabel($crudEdit->items['cms_layout_id']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['cms_layout_id'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['activated']->model->hasErrors($crudEdit->items['cache_duration']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['cms_layout_id']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cms_layout_id']->type], [$crudEdit->items['cms_layout_id']->model, $crudEdit->items['cms_layout_id']->attribute, $crudEdit->items['cms_layout_id']->data, $crudEdit->items['cms_layout_id']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cms_layout_id']->type], [$crudEdit->items['cms_layout_id']->model, $crudEdit->items['cms_layout_id']->attribute, $crudEdit->items['cms_layout_id']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['cms_layout_id'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cms_layout_id']->start->type], [$crudEdit->items['cms_layout_id']->start->model, $crudEdit->items['cms_layout_id']->start->attribute, $crudEdit->items['cms_layout_id']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['cms_layout_id']->end->type], [$crudEdit->items['cms_layout_id']->end->model, $crudEdit->items['cms_layout_id']->end->attribute, $crudEdit->items['cms_layout_id']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['cms_layout_id'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['cms_layout_id']->value; ?>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="<?= $crudEdit->items['slug']->attribute ?>">
        <th><?= $crudEdit->items['slug']->label !== null ? $crudEdit->items['slug']->label : $crudEdit->items['slug']->model->getAttributeLabel($crudEdit->items['slug']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['slug'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['slug']->model->hasErrors($crudEdit->items['slug']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['slug']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['slug']->type], [$crudEdit->items['slug']->model, $crudEdit->items['slug']->attribute, $crudEdit->items['slug']->data, $crudEdit->items['slug']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['slug']->type], [$crudEdit->items['slug']->model, $crudEdit->items['slug']->attribute, $crudEdit->items['slug']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['slug'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['slug']->start->type], [$crudEdit->items['slug']->start->model, $crudEdit->items['slug']->start->attribute, $crudEdit->items['slug']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['slug']->end->type], [$crudEdit->items['slug']->end->model, $crudEdit->items['slug']->end->attribute, $crudEdit->items['slug']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['slug'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['slug']->value; ?>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="<?= $crudEdit->items['html_title']->attribute ?>">
        <th><?= $crudEdit->items['html_title']->label !== null ? $crudEdit->items['html_title']->label : $crudEdit->items['html_title']->model->getAttributeLabel($crudEdit->items['html_title']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['html_title'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['html_title']->model->hasErrors($crudEdit->items['html_title']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['html_title']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_title']->type], [$crudEdit->items['html_title']->model, $crudEdit->items['html_title']->attribute, $crudEdit->items['html_title']->data, $crudEdit->items['html_title']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_title']->type], [$crudEdit->items['html_title']->model, $crudEdit->items['html_title']->attribute, $crudEdit->items['html_title']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['html_title'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_title']->start->type], [$crudEdit->items['html_title']->start->model, $crudEdit->items['html_title']->start->attribute, $crudEdit->items['html_title']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_title']->end->type], [$crudEdit->items['html_title']->end->model, $crudEdit->items['html_title']->end->attribute, $crudEdit->items['html_title']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['html_title'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['html_title']->value; ?>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="<?= $crudEdit->items['html_description']->attribute ?>">
        <th><?= $crudEdit->items['html_description']->label !== null ? $crudEdit->items['html_description']->label : $crudEdit->items['html_description']->model->getAttributeLabel($crudEdit->items['html_description']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['html_description'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['html_description']->model->hasErrors($crudEdit->items['html_description']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['html_description']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_description']->type], [$crudEdit->items['html_description']->model, $crudEdit->items['html_description']->attribute, $crudEdit->items['html_description']->data, $crudEdit->items['html_description']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_description']->type], [$crudEdit->items['html_description']->model, $crudEdit->items['html_description']->attribute, $crudEdit->items['html_description']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['html_description'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_description']->start->type], [$crudEdit->items['html_description']->start->model, $crudEdit->items['html_description']->start->attribute, $crudEdit->items['html_description']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_description']->end->type], [$crudEdit->items['html_description']->end->model, $crudEdit->items['html_description']->end->attribute, $crudEdit->items['html_description']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['html_description'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['html_description']->value; ?>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="<?= $crudEdit->items['html_keywords']->attribute ?>">
        <th><?= $crudEdit->items['html_keywords']->label !== null ? $crudEdit->items['html_keywords']->label : $crudEdit->items['html_keywords']->model->getAttributeLabel($crudEdit->items['html_keywords']->attribute); ?></th>
        <td>
            <?php if ($crudEdit->items['html_keywords'] instanceof InputField): ?>
                <div class="form-group<?= ($hasError = $crudEdit->items['html_keywords']->model->hasErrors($crudEdit->items['html_keywords']->attribute)) ? ' has-error' : ''; ?>">
                    <?php if (! empty($crudEdit->items['html_keywords']->data)): ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_keywords']->type], [$crudEdit->items['html_keywords']->model, $crudEdit->items['html_keywords']->attribute, $crudEdit->items['html_keywords']->data, $crudEdit->items['html_keywords']->options]); ?>
                    <?php else: ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_keywords']->type], [$crudEdit->items['html_keywords']->model, $crudEdit->items['html_keywords']->attribute, $crudEdit->items['html_keywords']->options]); ?>
                    <?php endif; ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['html_keywords'] instanceof DateRangeField): ?>
                <div class="form-group">
                    <?= Yii::t('kalibao', 'date_range_between'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_keywords']->start->type], [$crudEdit->items['html_keywords']->start->model, $crudEdit->items['html_keywords']->start->attribute, $crudEdit->items['html_keywords']->start->options]); ?>
                    <?= Yii::t('kalibao', 'date_range_separator'); ?>
                    <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['html_keywords']->end->type], [$crudEdit->items['html_keywords']->end->model, $crudEdit->items['html_keywords']->end->attribute, $crudEdit->items['html_keywords']->end->options]); ?>
                    <div class="control-label help-inline"></div>
                </div>
            <?php elseif ($crudEdit->items['html_keywords'] instanceof SimpleValueField): ?>
                <?= $crudEdit->items['html_keywords']->value; ?>
            <?php endif; ?>
        </td>
    </tr>

    <?php if (isset($crudEdit->getModels()['pageContents'])): ?>
        <?= $this->render('_pageContents', ['crudEdit' => $crudEdit]); ?>
    <?php endif; ?>

    <?php if (isset($crudEdit->items['created_at'])): ?>
        <tr class="<?= $crudEdit->items['created_at']->attribute ?>">
            <th><?= $crudEdit->items['created_at']->label !== null ? $crudEdit->items['created_at']->label : $crudEdit->items['created_at']->model->getAttributeLabel($crudEdit->items['created_at']->attribute); ?></th>
            <td>
                <?php if ($crudEdit->items['created_at'] instanceof InputField): ?>
                    <div class="form-group<?= ($hasError = $crudEdit->items['created_at']->model->hasErrors($crudEdit->items['created_at']->attribute)) ? ' has-error' : ''; ?>">
                        <?php if (! empty($crudEdit->items['created_at']->data)): ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['created_at']->type], [$crudEdit->items['created_at']->model, $crudEdit->items['created_at']->attribute, $crudEdit->items['created_at']->data, $crudEdit->items['created_at']->options]); ?>
                        <?php else: ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['created_at']->type], [$crudEdit->items['created_at']->model, $crudEdit->items['created_at']->attribute, $crudEdit->items['created_at']->options]); ?>
                        <?php endif; ?>
                        <div class="control-label help-inline"></div>
                    </div>
                <?php elseif ($crudEdit->items['created_at'] instanceof DateRangeField): ?>
                    <div class="form-group">
                        <?= Yii::t('kalibao', 'date_range_between'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['created_at']->start->type], [$crudEdit->items['created_at']->start->model, $crudEdit->items['created_at']->start->attribute, $crudEdit->items['created_at']->start->options]); ?>
                        <?= Yii::t('kalibao', 'date_range_separator'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['created_at']->end->type], [$crudEdit->items['created_at']->end->model, $crudEdit->items['created_at']->end->attribute, $crudEdit->items['created_at']->end->options]); ?>
                        <div class="control-label help-inline"></div>
                    </div>
                <?php elseif ($crudEdit->items['created_at'] instanceof SimpleValueField): ?>
                    <?= $crudEdit->items['created_at']->value; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>

    <?php if (isset($crudEdit->items['updated_at'])): ?>
        <tr class="<?= $crudEdit->items['updated_at']->attribute ?>">
            <th><?= $crudEdit->items['updated_at']->label !== null ? $crudEdit->items['updated_at']->label : $crudEdit->items['updated_at']->model->getAttributeLabel($crudEdit->items['updated_at']->attribute); ?></th>
            <td>
                <?php if ($crudEdit->items['updated_at'] instanceof InputField): ?>
                    <div class="form-group<?= ($hasError = $crudEdit->items['updated_at']->model->hasErrors($crudEdit->items['updated_at']->attribute)) ? ' has-error' : ''; ?>">
                        <?php if (! empty($crudEdit->items['updated_at']->data)): ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['updated_at']->type], [$crudEdit->items['updated_at']->model, $crudEdit->items['updated_at']->attribute, $crudEdit->items['updated_at']->data, $crudEdit->items['updated_at']->options]); ?>
                        <?php else: ?>
                            <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['updated_at']->type], [$crudEdit->items['updated_at']->model, $crudEdit->items['updated_at']->attribute, $crudEdit->items['updated_at']->options]); ?>
                        <?php endif; ?>
                        <div class="control-label help-inline"></div>
                    </div>
                <?php elseif ($crudEdit->items['id'] instanceof DateRangeField): ?>
                    <div class="form-group">
                        <?= Yii::t('kalibao', 'date_range_between'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['id']->start->type], [$crudEdit->items['id']->start->model, $crudEdit->items['id']->start->attribute, $crudEdit->items['id']->start->options]); ?>
                        <?= Yii::t('kalibao', 'date_range_separator'); ?>
                        <?= call_user_func_array(['\kalibao\common\components\helpers\Html', $crudEdit->items['id']->end->type], [$crudEdit->items['id']->end->model, $crudEdit->items['id']->end->attribute, $crudEdit->items['id']->end->options]); ?>
                        <div class="control-label help-inline"></div>
                    </div>
                <?php elseif ($crudEdit->items['updated_at'] instanceof SimpleValueField): ?>
                    <?= $crudEdit->items['updated_at']->value; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
</tbody>