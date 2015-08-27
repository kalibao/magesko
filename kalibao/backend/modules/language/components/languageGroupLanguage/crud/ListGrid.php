<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\language\components\languageGroupLanguage\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\language\components\languageGroupLanguage\crud
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
        $this->setTitle(Yii::t('kalibao.backend', 'language_language_group_language_list_title'));

        // set head attributes
        $this->setGridHeadAttributes([
            'language_group_i18n_title' => true,
            'language_i18n_title' => true,
            'activated' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'language_group_id',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('language_group_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'language_id',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('language_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'activated',
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
                'attribute' => 'language_group_id',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('language_group_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'language_id',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('language_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'activated',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('checkbox-drop-down-list'),
                'options' => [
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                    'class' => 'form-control input-sm',
                ]
            ]),
        ]);
    }
}