<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\attribute\components\attribute\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
use kalibao\common\models\attributeType\AttributeTypeI18n;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\attribute\components\attribute\crud
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
            'attribute_type_i18n_value' => true,
            'attribute_i18n_value' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'attribute_type_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'attribute_type_i18n.value',
                    ]),
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($model->attribute_type_id) ? AttributeTypeI18n::findOne([
                        'attribute_type_id' => $model->attribute_type_id,
                        'i18n_id' => $language
                    ])->value : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'attribute_i18n_value',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
        ]);

        // set advanced filters
        $this->setAdvancedFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'attribute_type_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'attribute_type_i18n.value',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($model->attribute_type_id) ? AttributeTypeI18n::findOne([
                        'attribute_type_id' => $model->attribute_type_id,
                        'i18n_id' => $language
                    ])->value : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'attribute_i18n_value',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
        ]);
    }
}