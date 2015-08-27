<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsPage\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\cmsLayout\CmsLayoutI18n;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\cms\components\cmsPage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Edit extends \kalibao\common\components\crud\Edit
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set titles
        $this->setCreateTitle(Yii::t('kalibao.backend', 'cms_page_create_title'));
        $this->setUpdateTitle(Yii::t('kalibao.backend', 'cms_page_update_title'));

        // models
        $models = $this->getModels();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // upload config
        $uploadConfig['main'] = $this->uploadConfig[(new \ReflectionClass($models['main']))->getName()];

        // set items
        $items = [];

        if (!$models['main']->isNewRecord) {
            $items['id'] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'id',
                'value' => $models['main']->id,
            ]);
        }

        $items['title'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('title'),
            ]
        ]);

        $items['activated'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'activated',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['cache_duration'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'cache_duration',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('cache_duration'),
            ]
        ]);

        $items['cms_layout_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'cms_layout_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select input-ajax-select-layout',
                'data-url-page-contents' => Url::to(['load-page-contents']),
                'data-page-id' => !$models['main']->isNewRecord ? $models['main']->id : '',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'cms_layout_i18n.name',
                ]),
                'data-add-action' => Url::to('/cms/cms-layout/create'),
                'data-update-action' => Url::to('/cms/cms-layout/update'),
                'data-update-argument' => 'id',
                'data-related-field' => '.link_cms_layout_name',
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->cms_layout_id) ? CmsLayoutI18n::findOne([
                    'cms_layout_id' => $models['main']->cms_layout_id,
                    'i18n_id' => $language
                ])->name : '',
            ]
        ]);

        $items['slug'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'slug',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm active-slug',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('slug'),
            ]
        ]);

        $items['html_title'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'html_title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('html_title'),
            ]
        ]);

        $items['html_description'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'html_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $models['i18n']->getAttributeLabel('html_description'),
            ]
        ]);

        $items['html_keywords'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'html_keywords',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('html_keywords'),
            ]
        ]);

        if (isset($models['pageContents'])) {
            $editPageContents = new EditPageContents([
                'language' => $this->getLanguage(),
                'models' => ['pageContents' => $models['pageContents']],
            ]);
            $items = array_merge($items, $editPageContents->getItems());
        }

        if (!$models['main']->isNewRecord) {
            $items['created_at'] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->created_at, I18N::getDateFormat())
            ]);
        }

        if (!$models['main']->isNewRecord) {
            $items['updated_at'] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'updated_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->updated_at, I18N::getDateFormat())
            ]);
        }

        $this->setItems($items);
    }
}