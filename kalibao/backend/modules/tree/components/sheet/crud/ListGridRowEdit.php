<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\sheet\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\sheetType\SheetTypeI18n;
use kalibao\common\models\branch\BranchI18n;

/**
 * Class ListGridRowEdit
 *
 * @package kalibao\backend\modules\tree\components\sheet\crud
 * @version 1.0
 */
class ListGridRowEdit extends \kalibao\common\components\crud\ListGridRowEdit
{
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

        $items[] = new SimpleValueField([
            'model' => $models['main'],
            'attribute' => 'id',
            'value' => $models['main']->id,
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'sheet_type_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'sheet_type_i18n.label',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->sheet_type_id) ? SheetTypeI18n::findOne([
                    'sheet_type_id' => $models['main']->sheet_type_id,
                    'i18n_id' => $language
                ])->label : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'branch_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'branch_i18n.label',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->branch_id) ? BranchI18n::findOne([
                    'branch_id' => $models['main']->branch_id,
                    'i18n_id' => $language
                ])->label : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'primary_key',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('primary_key'),
            ]
        ]);

        $items[] = new SimpleValueField([
            'model' => $models['main'],
            'attribute' => 'created_at',
            'value' => Yii::$app->formatter->asDatetime($models['main']->created_at, I18N::getDateFormat())
        ]);

        $items[] = new SimpleValueField([
            'model' => $models['main'],
            'attribute' => 'updated_at',
            'value' => Yii::$app->formatter->asDatetime($models['main']->updated_at, I18N::getDateFormat())
        ]);

        $this->setItems($items);
    }
}