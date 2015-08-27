<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\tree\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\treeType\TreeTypeI18n;
use kalibao\common\models\media\MediaI18n;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\tree\components\tree\crud
 * @version 1.0
 */
class Edit extends \kalibao\common\components\crud\Edit
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set titles
        $this->setCreateTitle(Yii::t('kalibao', 'create_title'));
        $this->setUpdateTitle(Yii::t('kalibao', 'update_title'));

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

        if (!$models['main']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'id',
                'value' => $models['main']->id,
            ]);
        }

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'tree_type_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'tree_type_i18n.label',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->tree_type_id) ? TreeTypeI18n::findOne([
                    'tree_type_id' => $models['main']->tree_type_id,
                    'i18n_id' => $language
                ])->label : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'media_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'media_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->media_id) ? MediaI18n::findOne([
                    'media_id' => $models['main']->media_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'label',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('label'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);

        if (!$models['main']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->created_at, I18N::getDateFormat())
            ]);
        }

        if (!$models['main']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['main'],
                'attribute' => 'updated_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->updated_at, I18N::getDateFormat())
            ]);
        }

        $this->setItems($items);
    }
}