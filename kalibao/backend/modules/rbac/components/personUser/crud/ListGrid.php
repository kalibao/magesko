<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\rbac\components\personUser\crud;

use kalibao\common\models\third\Third;
use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
use kalibao\common\models\language\LanguageI18n;
use kalibao\common\models\user\User;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\rbac\components\person\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
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
        $this->setTitle(Yii::t('kalibao.backend', 'rbac_user_list_title'));

        // set head attributes
        $this->setGridHeadAttributes([
            'first_name' => true,
            'last_name' => true,
            'email' => true,
            'language_i18n_title' => true,
            'user_status' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'first_name',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'last_name',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'email',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'default_language',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'language_i18n.title',
                    ]),
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($model->default_language) ? LanguageI18n::findOne([
                        'language_id' => $model->default_language,
                        'i18n_id' => $language
                    ])->title : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'user_status',
                'type' => 'activeDropDownList',
                'data'=> $dropDownList('user.status'),
                'options' => [
                    'class' => 'form-control input-sm',
                ]
            ]),
        ]);

        // set advanced filters
        $this->setAdvancedFilters([
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
                'attribute' => 'first_name',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'last_name',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'email',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'default_language',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'language_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($model->default_language) ? LanguageI18n::findOne([
                        'language_id' => $model->default_language,
                        'i18n_id' => $language
                    ])->title : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'user_status',
                'type' => 'activeDropDownList',
                'data'=> $dropDownList('user.status'),
                'options' => [
                    'class' => 'form-control input-sm',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'user_active_password_reset',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('checkbox-drop-down-list'),
                'options' => [
                    'class' => 'form-control input-sm',
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