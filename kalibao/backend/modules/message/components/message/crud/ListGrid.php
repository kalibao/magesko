<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\message\components\message\crud;


use Yii;
use yii\helpers\Url;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\message\components\message\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGrid extends \kalibao\common\components\crud\ListGrid
{
    /**
     * @var \yii\db\ActiveRecord[] Groups of languages
     */
    public $languagesGroups;

    /**
     * @var \yii\db\ActiveRecord[] Languages of language group
     */
    public $languageGroupLanguages;

    /**
     * @var integer Language group ID
     */
    public $languageGroupId;

    /**
     * @var \yii\db\ActiveRecord[] Message groups
     */
    public $messageGroups;

    /**
     * @var array Array of models class
     */
    public $crudModelsClass;

    /**
     * @var array Array of components class
     */
    public $crudComponentsClass;

    /**
     * @var saved status
     */
    public $saved;

    /**
     * @var ListGridRowEdit[] Rows
     */
    protected $gridRowsEdit = [];

    private $dataProvider;

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
        $this->setTitle(Yii::t('kalibao.backend', 'message_message_list_title'));

        $gridHeadAttributes = [
            'source' => true,
            'message_group_i18n_title' => true,
        ];

        $languageLabels = [];
        foreach($this->languageGroupLanguages as $language) {
            if (isset($language->languageI18ns[0])) {
                $languageLabels[$language->language_id] = Html::labelI18n($language->language_id);
            }
        }

        $headFilters = [
            new InputField([
                'model' => $model,
                'attribute' => 'source',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'message_group_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'message_group_i18n.title',
                    ]),
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($model->message_group_id) ? $this->messageGroups[$model->message_group_id]->name : '',
                ]
            ])
        ];

        $advancedHeadFilters = [
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
                'attribute' => 'source',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
            new InputField([
                'model' => $model,
                'attribute' => 'message_group_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'message_group_i18n.title',
                    ]),
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($model->message_group_id) ? $this->messageGroups[$model->message_group_id]->title : '',
                ]
            ])
        ];

        $languageLabels = $this->orderLanguage($languageLabels);
        foreach ($languageLabels as $languageId => $attribute) {
            $gridHeadAttributes[] = $attribute;
            $headFilters[] = new InputField([
                'model' => $model,
                'attribute' => 'message_i18n_translation['.$languageId.']',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                    'name' => (new \ReflectionClass($model))->getShortName().'[message_i18n_translation]['.$languageId.']'
                ]
            ]);
            $advancedHeadFilters[] = new InputField([
                'model' => $model,
                'attribute' => 'message_i18n_translation['.$languageId.']',
                'type' => 'activeTextInput',
                'label' => Html::labelI18n($languageId),
                'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                    'name' => (new \ReflectionClass($model))->getShortName().'[message_i18n_translation]['.$languageId.']'
                ]
            ]);
        }

        $advancedHeadFilters[] = new DateRangeField([
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
        ]);

        $advancedHeadFilters[] = new DateRangeField([
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
        ]);

        // set head attributes
        $this->setGridHeadAttributes($gridHeadAttributes);

        // set head filters
        $this->setGridHeadFilters($headFilters);

        // set advanced filters
        $this->setAdvancedFilters($advancedHeadFilters);
    }

    /**
     * Get rows of grid
     * @param bool $refresh Refresh grid
     * @return ListGridRowEdit[]
     */
    public function getGridRowsEdit($refresh = false)
    {
        if (!empty($this->languageGroupLanguages) && (empty($this->gridRowsEdit) || $refresh === true)) {
            $this->gridRowsEdit = [];

            $languageGroupLanguages = [];
            foreach($this->languageGroupLanguages as $languageGroupLanguage) {
                if (isset($languageGroupLanguage->languageI18ns[0])) {
                    $languageGroupLanguages[$languageGroupLanguage->language_id] = $languageGroupLanguage;
                }
            }
            $languageGroupLanguages = $this->orderLanguage($languageGroupLanguages);

            foreach ($this->getDataProvider($refresh)->getModels() as $models) {
                $modelsRefactor['main'] = new $this->crudModelsClass['main'](['scenario' => 'update']);
                $modelsRefactor['main']->id = $models['id'];
                $modelsRefactor['main']->message_group_id = $models['message_group_id'];
                $modelsRefactor['main']->source = $models['source'];
                $modelsRefactor['main']->created_at = $models['created_at'];
                $modelsRefactor['main']->updated_at = $models['updated_at'];
                $modelsRefactor['main']->setIsNewRecord(false);

                foreach($languageGroupLanguages as $languageGroupLanguage) {
                    if (isset($languageGroupLanguage->languageI18ns[0])) {
                        $modelsRefactor['i18n'][$languageGroupLanguage->language_id] = new $this->crudModelsClass['i18n']();
                        $modelsRefactor['i18n'][$languageGroupLanguage->language_id]->message_id = $models['id'];
                        $modelsRefactor['i18n'][$languageGroupLanguage->language_id]->i18n_id = $languageGroupLanguage->language_id;
                        $modelsRefactor['i18n'][$languageGroupLanguage->language_id]->translation = $models['message_i18n_'.$languageGroupLanguage->language_id.'_translation'];
                        if ($models['message_i18n_'.$languageGroupLanguage->language_id.'_message_id'] !== null) {
                            $modelsRefactor['i18n'][$languageGroupLanguage->language_id]->setIsNewRecord(false);
                            $modelsRefactor['i18n'][$languageGroupLanguage->language_id]->scenario = 'update';
                        } else {
                            $modelsRefactor['i18n'][$languageGroupLanguage->language_id]->scenario = 'insert';
                        }
                    }
                }

                $gridRow = new $this->crudComponentsClass['listFieldsEdit']([
                    'models' => $modelsRefactor,
                    'language' => Yii::$app->language,
                    'requestParams' => $this->requestParams,
                    'messageGroups' => $this->messageGroups,
                    'dropDownList' => function ($id) {
                        return $this->getDropDownList($id);
                    }
                ]);

                $this->addRowEdit($gridRow);
            }
        }
        return $this->gridRowsEdit;
    }

    /**
     * Add row
     * @param ListGridRowEdit $row
     */
    public function addRowEdit(ListGridRowEdit $row)
    {
        $this->gridRowsEdit[$row->models['main']->id] = $row;
    }

    /**
     * Get data provider
     * @param bool $refresh Refresh parameters sent to the search method
     * @return \yii\data\ActiveDataProvider
     */
    public function getDataProvider($refresh = false)
    {
        if ($this->dataProvider === null || $refresh === true) {
            $this->dataProvider = $this->getModel()->search(
                $this->requestParams,
                $this->languageGroupLanguages,
                $this->language,
                $this->pageSize
            );
            if ($this->defaultAction !== null) {
                $this->dataProvider->sort->route = $this->defaultAction;
                $this->dataProvider->pagination->route = $this->defaultAction;
            }
        }

        return $this->dataProvider;
    }

    /**
     * Order languages
     * @param array $languages Languages
     * @return array
     */
    public function orderLanguage(array $languages)
    {
        $tmp = [];
        if (isset($languages[$this->language])) {
            $tmp[$this->language] = $languages[$this->language];
            unset($languages[$this->language]);
        }
        foreach ($languages as $languageId => $language) {
            $tmp[$languageId] = $language;
        }
        return $tmp;
    }
}