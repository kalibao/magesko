<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\category\components\category\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
use kalibao\common\models\category\CategoryI18n;
use kalibao\common\models\media\MediaI18n;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\category\components\category\crud
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
            'category_i18n_title' => true,
            'media_id' => true,
            'category_i18n_description' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'parent',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('category_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'media_id',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('media_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'category_i18n_description',
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
                'attribute' => 'parent',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('category_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'media_id',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('media_i18n.title'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'category_i18n_description',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
        ]);
    }
}