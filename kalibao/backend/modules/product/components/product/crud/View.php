<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
namespace kalibao\backend\modules\product\components\product\crud;

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\brand\Brand;
use kalibao\common\models\product\ProductI18n;
use kalibao\common\models\supplier\Supplier;
use Yii;
use yii\helpers\Url;

/**
 * Class Show
 *
 * @package kalibao\backend\modules\product\components\product\crud
 * @version 1.0
 */
class View extends \kalibao\common\components\crud\Edit
{
    protected $tree;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

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

        $tree = $this->getTree();

        if (!$models['main']->isNewRecord) {
            $items['id'] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'id',
                'value' => $models['main']->id,
            ]);
        }

        $items['exclude_discount_code'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'exclude_discount_code',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['force_secure'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'force_secure',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['archived'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'archived',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['top_product'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'top_product',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['exclude_from_google'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'exclude_from_google',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['link_brand_product'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'link_brand_product',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('link_brand_product'),
            ]
        ]);

        $items['link_product_test'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'link_product_test',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('link_product_test'),
            ]
        ]);

        $items['available'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'available',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['available_date'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'available_date',
            'type' => 'activeTextInput',
            'required' => true,
            'options' => [
                'class' => 'required form-control input-sm date-picker date-range',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('available_date'),
                'rel' => (isset($models['main']->available_date))?$models['main']->available_date:date('Y-m-d')
            ]
        ]);

        $items['alternative_product'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'alternative_product',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'product_i18n.name',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->alternative_product) ? ProductI18n::findOne([
                    'product_id' => $models['main']->alternative_product,
                    'i18n_id' => $language
                ])->name : '',
            ]
        ]);

        $items['brand_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'brand_id',
            'type' => 'activeHiddenInput',
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm input-ajax-select required',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'brand.name',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->brand_id) ? Brand::findOne([
                    'id' => $models['main']->brand_id
                ])->name : '',
            ]
        ]);

        $items['supplier_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'supplier_id',
            'type' => 'activeHiddenInput',
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm input-ajax-select required',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'supplier.name',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->supplier_id) ? Supplier::findOne([
                    'id' => $models['main']->supplier_id
                ])->name : '',
            ]
        ]);

        $items['catalog_category_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'catalog_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('category_i18n.title'),
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm required',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('catalog_category_id'),
            ]
        ]);

        $items['google_category_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'google_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('category_i18n.title'),
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm required',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('google_category_id'),
            ]
        ]);

        $items['stats_category_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'stats_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('category_i18n.title'),
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm required',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('stats_category_id'),
            ]
        ]);

        $items['accountant_category_id'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'accountant_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('category_i18n.title'),
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm required',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('accountant_category_id'),
            ]
        ]);

        $items['base_price'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'base_price',
            'type' => 'activeTextInput',
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm required',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('base_price'),
                'id' => 'base_price',
            ]
        ]);

        $items['is_pack'] = new InputField([
            'model' => $models['main'],
            'attribute' => 'is_pack',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items['short_description'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'short_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language,
                'id' => 'product_sh_d'
            ]
        ]);

        $items['long_description'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'long_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language,
                'id' => 'product_lg_d'
            ]
        ]);

        $items['comment'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'comment',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language,
                'id' => 'product_comm'
            ]
        ]);

        $items['page_title'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'page_title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('page_title'),
            ]
        ]);

        $items['name'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'name',
            'type' => 'activeTextInput',
            'required' => true,
            'options' => [
                'class' => 'form-control input-sm required',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('name'),
            ]
        ]);

        $items['infos_shipping'] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'infos_shipping',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language,
                'id' => 'product_ship'
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

    /**
     * @return string
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @param string $tree
     */
    public function setTree($tree)
    {
        $this->tree = $tree;
    }
}