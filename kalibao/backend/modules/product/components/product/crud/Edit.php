<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\product\components\product\crud;

use kalibao\common\components\crud\InputField;
use kalibao\common\models\brand\Brand;
use kalibao\common\models\product\ProductI18n;
use kalibao\common\models\supplier\Supplier;
use Yii;
use yii\helpers\Url;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\product\components\product\crud
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

        // set items
        $items = [];

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'available_date',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'required form-control input-sm date-picker date-range',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('available_date'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'brand_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'required form-control input-sm input-ajax-select',
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

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'supplier_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'required form-control input-sm input-ajax-select',
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

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'google_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('category_i18n.title'),
            'options' => [
                'class' => 'required form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('google_category_id'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'stats_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('category_i18n.title'),
            'options' => [
                'class' => 'required form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('stats_category_id'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'accountant_category_id',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('category_i18n.title'),
            'options' => [
                'class' => 'required form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('accountant_category_id'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'required form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('name'),
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

        $this->setItems($items);
    }
}