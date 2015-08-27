<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\address\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
use kalibao\common\models\third\Third;
use kalibao\common\models\address\AddressTypeI18n;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\third\components\address\crud
 * @version 1.0
 */
class ListGrid extends \kalibao\common\components\crud\ListGrid
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // get model
        $model = $this->getModel();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // set titles
        $this->setTitle(Yii::t('kalibao', 'list_title'));

        // set head attributes
        $this->setGridHeadAttributes([
            'address_type_i18n_title' => true,
            'label' => true,
            'place_1' => true,
            'street_number' => true,
            'zip_code' => true,
            'city' => true,
            'country' => true,
            'is_primary' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'address_type_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'address_type_i18n.title',
                    ]),
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($model->address_type_id) ? AddressTypeI18n::findOne([
                        'address_type_id' => $model->address_type_id,
                        'i18n_id' => $language
                    ])->title : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'label',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'place_1',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'street_number',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'zip_code',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'city',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'country',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'is_primary',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('checkbox-drop-down-list'),
                'options' => [
                    'class' => 'form-control input-sm',
                ]
            ]),
        ]);

        // set advanced filters
        $this->setAdvancedFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'id',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'third_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'third.id',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($model->third_id) ? Third::findOne([
                        'id' => $model->third_id
                    ])->id : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'address_type_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'address_type_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($model->address_type_id) ? AddressTypeI18n::findOne([
                        'address_type_id' => $model->address_type_id,
                        'i18n_id' => $language
                    ])->title : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'label',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'place_1',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'place_2',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'street_number',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'door_code',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'zip_code',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'city',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'country',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'is_primary',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('checkbox-drop-down-list'),
                'options' => [
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                    'class' => 'form-control input-sm',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'note',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new DateRangeField([
                'model' => $model,
                'attribute' => 'created_at',
                'start' => new InputField([
                    'model' => $model,
                    'attribute' => 'created_at_start',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ]),
                'end' => new InputField([
                    'model' => $model,
                    'attribute' => 'created_at_end',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ])
            ]),
            new DateRangeField([
                'model' => $model,
                'attribute' => 'updated_at',
                'start' => new InputField([
                    'model' => $model,
                    'attribute' => 'updated_at_start',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ]),
                'end' => new InputField([
                    'model' => $model,
                    'attribute' => 'updated_at_end',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ])
            ]),
        ]);
    }
}