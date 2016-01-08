<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\media\components\media\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
use kalibao\common\models\mediaType\MediaTypeI18n;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\media\components\media\crud
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
            'media_type_i18n_title' => true,
            'media_i18n_title' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'media_type_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'media_type_i18n.title',
                    ]),
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($model->media_type_id) ? MediaTypeI18n::findOne([
                        'media_type_id' => $model->media_type_id,
                        'i18n_id' => $language
                    ])->title : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'media_i18n_title',
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
                'attribute' => 'media_type_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'media_type_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($model->media_type_id) ? MediaTypeI18n::findOne([
                        'media_type_id' => $model->media_type_id,
                        'i18n_id' => $language
                    ])->title : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'media_i18n_title',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
        ]);
    }
}