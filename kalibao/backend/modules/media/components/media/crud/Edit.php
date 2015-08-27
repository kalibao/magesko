<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\media\components\media\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\mediaType\MediaTypeI18n;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\media\components\media\crud
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
            'attribute' => 'file',
            'type' => 'activeFileInput',
            'options' => [
                'maxlength' => true,
                'class' => 'input-advanced-uploader',
                'placeholder' => $models['main']->getAttributeLabel('file'),
                'data-type-uploader' => $uploadConfig['main']['file']['type'],
                'data-file-url' => ($models['main']->file != '') ?
                    $uploadConfig['main']['file']['baseUrl'] . '/'
                    . $models['main']->file : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
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
                'data-text' => !empty($models['main']->media_type_id) ? MediaTypeI18n::findOne([
                    'media_type_id' => $models['main']->media_type_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['i18n']->getAttributeLabel('title'),
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