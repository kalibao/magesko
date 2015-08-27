<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\message\components\message\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\messageGroup\MessageGroupI18n;

/**
 * Class ListGridRowEdit
 *
 * @package kalibao\backend\modules\message\components\message\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGridRowEdit extends \kalibao\common\components\crud\ListGridRowEdit
{
    /**
     * @var \yii\db\ActiveRecord[] Message groups
     */
    public $messageGroups;

    /**
     * @return string[]
     */
    public function getItems()
    {
        if ($this->items === null) {
            // models
            $models = $this->getModels();

            // language
            $language = $this->getLanguage();

            // get drop down list methods
            $dropDownList = $this->getDropDownList();

            // set items
            $items = [];

            $classShortName['main'] = (new \ReflectionClass($models['main']))->getShortName();


            $items[] = new InputField([
                'model' => $models['main'],
                'attribute' => 'source',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'name' => $classShortName['main'].'['.$models['main']->id.'][source]',
                    'placeholder' => $models['main']->getAttributeLabel('source'),
                ]
            ]);

            $items[] = new InputField([
                'model' => $models['main'],
                'attribute' => 'message_group_id',
                'type' => 'activeHiddenInput',
                'options' => [
                    'class' => 'form-control input-sm input-ajax-select',
                    'name' => $classShortName['main'].'['.$models['main']->id.'][message_group_id]',
                    'data-action' => Url::to([
                        'advanced-drop-down-list',
                        'id' => 'message_group_i18n.title',
                    ]),
                    'data-add-action' => Url::to('/message/message-group/create'),
                    'data-update-action' => Url::to('/message/message-group/update'),
                    'data-update-argument' => 'id',
                    'data-related-field' => '.link_message_group_title',
                    'data-allow-clear' => 1,
                    'data-placeholder' => Yii::t('kalibao', 'input_select'),
                    'data-text' => !empty($models['main']->message_group_id) ? $this->messageGroups[$models['main']->message_group_id]->title : '',
                ]
            ]);

            foreach ($models['i18n'] as $languageId => $model) {
                $classShortName['i18n'] = (new \ReflectionClass($model))->getShortName();
                $items[] = new InputField([
                    'model' => $model,
                    'attribute' => 'translation',
                    'type' => 'activeTextarea',
                    'options' => [
                        'class' => 'form-control input-sm',
                        'name' => $classShortName['i18n'].'['.$models['main']->id.']['.$languageId.'][translation]',
                        'maxlength' => true,
                        'placeholder' => $models['main']->getAttributeLabel('translation'),
                    ]
                ]);
            }

            $this->items = $items;
        }

        return $this->items;
    }
}