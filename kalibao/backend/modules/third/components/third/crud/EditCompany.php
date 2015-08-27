<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\third\crud;

use kalibao\common\models\company\CompanyTypeI18n;
use kalibao\common\models\language\LanguageI18n;
use kalibao\common\models\third\Third;
use kalibao\common\models\user\User;
use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\third\ThirdRoleI18n;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\third\components\third\crud
 * @version 1.0
 */
class EditCompany extends \kalibao\common\components\crud\Edit
{
    public function getAction()
    {
        if ($this->models['main']->isNewRecord) {
            return Url::to(['create-third', 'interface' => (int)Third::COMPANY_INTERFACE]);
        } else {
            return Url::to(['update'] + $this->models['main']->getPrimaryKey(true));
        }
    }
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
        $uploadConfig['company'] = $this->uploadConfig[(new \ReflectionClass($models['company']))->getName()];

        // set items
        $items = [];

        $items[] = new InputField([
            'model' => $models['company'],
            'attribute' => 'company_type',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'company_type_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-add-action' => Url::to('/third/company-type/create'),
                'data-update-action' => Url::to('/third/company-type/update'),
                'data-update-argument' => 'id',
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['company']->company_type) ? CompanyTypeI18n::findOne([
                    'company_type_id' => $models['company']->company_type,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['company'],
            'attribute' => 'name',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['company']->getAttributeLabel('name'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['company'],
            'attribute' => 'tva_number',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['company']->getAttributeLabel('tva_number'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['company'],
            'attribute' => 'naf',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['company']->getAttributeLabel('naf'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['company'],
            'attribute' => 'siren',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['company']->getAttributeLabel('siren'),
            ]
        ]);
        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'note',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('note'),
            ]
        ]);

        if (!$models['main']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['company'],
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->created_at, I18N::getDateFormat())
            ]);
            $items[] = new SimpleValueField([
                'model' => $models['company'],
                'attribute' => 'updated_at',
                'value' => Yii::$app->formatter->asDatetime($models['main']->updated_at, I18N::getDateFormat())
            ]);
        }

        $this->setItems($items);
    }
}