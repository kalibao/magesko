<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\components\mailTemplate\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\mailTemplateGroup\MailTemplateGroupI18n;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\mail\components\mailTemplate\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
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
        $this->setCreateTitle(Yii::t('kalibao.backend', 'mail_mail_template_create_title'));
        $this->setUpdateTitle(Yii::t('kalibao.backend', 'mail_mail_template_update_title'));

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
            'attribute' => 'mail_template_group_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'mail_template_group_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-add-action' => Url::to('/mail/mail-template-group/create'),
                'data-update-action' => Url::to('/mail/mail-template-group/update'),
                'data-update-argument' => 'id',
                'data-related-field' => '.link_mail_template_group_title',
                'data-text' => !empty($models['main']->mail_template_group_id) ? MailTemplateGroupI18n::findOne([
                    'mail_template_group_id' => $models['main']->mail_template_group_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'html_mode',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'sql_request',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $models['i18n']->getAttributeLabel('sql_request'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'sql_param',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('sql_param'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'object',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('object'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'message',
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