<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\attributeType\components\attributeType\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\attributeType\components\attributeType\crud
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
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'attribute_type_i18n_value',
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
                'attribute' => 'attribute_type_i18n_value',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
        ]);
    }
}