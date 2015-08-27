<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsNews\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\cms\components\cmsNews\crud
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
        $this->setTitle(Yii::t('kalibao.backend', 'cms_news_list_title'));

        // set head attributes
        $this->setGridHeadAttributes([
            'cms_news_i18n_title' => true,
            'cms_news_group_i18n_title' => true,
            'activated' => true,
            'published_at' => true,
        ]);

        // set head filters
        $this->setGridHeadFilters([
            new InputField([
                'model' => $model,
                'attribute' => 'cms_news_i18n_title',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'cms_news_group_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'cms_news_group_i18n.title',
                    ]),
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($model->cms_news_group_id) ? CmsNewsGroupI18n::findOne([
                        'cms_news_group_id' => $model->cms_news_group_id,
                        'i18n_id' => $language
                    ])->title : '',
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
            new InputField([
                'model' => $model,
                'attribute' => 'published_at',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm date-picker date-range',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
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
                'attribute' => 'cms_news_i18n_title',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'cms_news_group_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'cms_news_group_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($model->cms_news_group_id) ? CmsNewsGroupI18n::findOne([
                        'cms_news_group_id' => $model->cms_news_group_id,
                        'i18n_id' => $language
                    ])->title : '',
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'cms_news_i18n_content',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
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
            new InputField([
                'model' => $model,
                'attribute' => 'published_at',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm date-picker date-range',
                    'maxlength' => true,
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