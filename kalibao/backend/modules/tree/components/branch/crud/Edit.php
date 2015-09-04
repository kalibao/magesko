<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\branch\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\branchType\BranchTypeI18n;
use kalibao\common\models\tree\TreeI18n;
use kalibao\common\models\branch\BranchI18n;
use kalibao\common\models\media\MediaI18n;
use kalibao\common\models\googleShoppingCategory\GoogleShoppingCategory;
use kalibao\common\models\affiliationCategory\AffiliationCategory;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\tree\components\branch\crud
 * @version 1.0
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
        $this->setCreateTitle(Yii::t('kalibao', 'create_title'));
        $this->setUpdateTitle(Yii::t('kalibao', 'update_title'));

        // models
        $models = $this->getModels();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // upload config
        $uploadConfig['main'] = $this->uploadConfig[(new \ReflectionClass($models['main']))->getName()];

        $this->setCloseAction('/tree/tree/view?id=' . $models['main']->tree_id);

        // set items
        $items = [];

        if (!$models['main']->isNewRecord) {
            $items['id'] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'id',
                'value' => $models['main']->id,
            ]);
        }

        $items['branch_type_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'branch_type_id',
            'type' => 'activeHiddenInput',
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm input-ajax-select required',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'branch_type_i18n.label',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->branch_type_id) ? BranchTypeI18n::findOne([
                    'branch_type_id' => $models['main']->branch_type_id,
                    'i18n_id' => $language
                ])->label : '',
            ]
        ]);

        $items['tree_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'tree_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'tree_i18n.label',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->tree_id) ? TreeI18n::findOne([
                    'tree_id' => $models['main']->tree_id,
                    'i18n_id' => $language
                ])->label : '',
            ]
        ]);

        $items['parent'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'parent',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'branch_i18n.label',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->parent && $models['main']->parent != 1) ? BranchI18n::findOne([
                    'branch_id' => $models['main']->parent,
                    'i18n_id' => $language
                ])->label : '',
            ]
        ]);

        $items['order'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'order',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('order'),
            ]
        ]);

        $items['media_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'media_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'media_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->media_id) ? MediaI18n::findOne([
                    'media_id' => $models['main']->media_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items['visible'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'visible',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['background'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'background',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('background'),
            ]
        ]);

        $items['presentation_type'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'presentation_type',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['offset'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'offset',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('offset'),
            ]
        ]);

        $items['display_brands_types'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'display_brands_types',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['big_menu_only_first_level'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'big_menu_only_first_level',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['unfold'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'unfold',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['google_shopping_category_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'google_shopping_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('google_shopping_category.id'),
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('google_shopping_category_id'),
            ]
        ]);

        $items['google_shopping'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'google_shopping',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['affiliation_category_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'affiliation_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('affiliation_category.id'),
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('affiliation_category_id'),
            ]
        ]);

        $items['affiliation'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'affiliation',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['label'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'label',
            'type' => 'activeTextInput',
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm required',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('label'),
            ]
        ]);

        $items['description'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);

        $items['url'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'url',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('url'),
            ]
        ]);

        $items['meta_title'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'meta_title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('meta_title'),
            ]
        ]);

        $items['meta_description'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'meta_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $models['i18n']->getAttributeLabel('meta_description'),
            ]
        ]);

        $items['meta_keywords'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'meta_keywords',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('meta_keywords'),
            ]
        ]);

        $items['h1_tag'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'h1_tag',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('h1_tag'),
            ]
        ]);

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