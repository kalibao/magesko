<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\country\components\country\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\country\components\country\crud
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
            'id' => true,
            'iso3' => true,
            'numcode' => true,
            'phonecode' => true,
            'country_i18n_name' => true,
            'created_at' => true,
            'updated_at' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
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
                'attribute' => 'iso3',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'numcode',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'phonecode',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'country_i18n_name',
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
                'attribute' => 'iso3',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'numcode',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'phonecode',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'country_i18n_name',
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