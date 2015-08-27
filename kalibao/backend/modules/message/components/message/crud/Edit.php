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
use kalibao\common\components\helpers\Html;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\message\components\message\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Edit extends \kalibao\common\components\crud\Edit
{
    /**
     * @var integer Language group ID
     */
    public $languageGroupId;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set titles
        $this->setCreateTitle(Yii::t('kalibao.backend', 'message_message_create_title'));
        $this->setUpdateTitle(Yii::t('kalibao.backend', 'message_message_update_title'));

        // models
        $models = $this->getModels();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // set items
        $items = [];

        $items[] = new InputField([
            'model' => $models['main'],
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
                'data-add-action' => Url::to('/message/message-group/create'),
                'data-update-action' => Url::to('/message/message-group/update'),
                'data-update-argument' => 'id',
                'data-related-field' => '.link_message_group_title',
                'data-text' => !empty($models['main']->message_group_id) ? MessageGroupI18n::findOne([
                    'message_group_id' => $models['main']->message_group_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'source',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('source'),
            ]
        ]);

        $models['i18ns'] = $this->orderLanguage($models['i18ns']);
        foreach ($models['i18ns'] as $languageId => $model) {
            $items[] = new InputField([
                'model' => $model,
                'attribute' => 'translation',
                'type' => 'activeTextarea',
                'label' => Html::labelI18n($languageId),
                'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => $models['main']->getAttributeLabel('translation'),
                    'maxlength' => true,
                    'name' => (new \ReflectionClass($model))->getShortName().'['.$languageId.'][translation]'
                ]
            ]);
        }

        $this->setItems($items);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        if ($this->models['main']->isNewRecord) {
            return Url::to([
                'create',
                'add-again' => (int) $this->addAgain,
                'language_group_id' => $this->languageGroupId
            ]);
        }
        return Url::to(['update', 'language_group_id' => $this->languageGroupId] + $this->models['main']->getPrimaryKey(true));
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