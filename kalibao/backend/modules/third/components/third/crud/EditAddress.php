<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\third\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\third\Third;
use kalibao\common\models\address\AddressTypeI18n;

/**
 * Class Edit
 *
 * @package kalibao\backend\modules\third\components\address\crud
 * @version 1.0
 */
class EditAddress extends \kalibao\common\components\crud\Edit
{
    /**
     * @return string
     */
    public function getAction()
    {
        if ($this->models['address']->isNewRecord) {
            return Url::to(['/third/address/create']);
        }
        return Url::to(['/third/address/update'] + $this->models['address']->getPrimaryKey(true));
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
        $uploadConfig['address'] = $this->uploadConfig[(new \ReflectionClass($models['address']))->getName()];

        // set items
        $items = [];

        if (!$models['address']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['address'],
                'attribute' => 'id',
                'value' => $models['address']->id,
            ]);
        }

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'third_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'third.id',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['address']->third_id) ? Third::findOne([
                    'id' => $models['address']->third_id
                ])->id : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'address_type_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'address_type_i18n.title',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['address']->address_type_id) ? AddressTypeI18n::findOne([
                    'address_type_id' => $models['address']->address_type_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'label',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('label'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'place_1',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('place_1'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'place_2',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('place_2'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'street_number',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('street_number'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'door_code',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('door_code'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'zip_code',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('zip_code'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'city',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('city'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'country',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('country'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'is_primary',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['address'],
            'attribute' => 'note',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['address']->getAttributeLabel('note'),
            ]
        ]);

        if (!$models['address']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['address'],
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($models['address']->created_at, I18N::getDateFormat())
            ]);
        }

        if (!$models['address']->isNewRecord) {
            $items[] = new SimpleValueField([
                'model' => $models['address'],
                'attribute' => 'updated_at',
                'value' => Yii::$app->formatter->asDatetime($models['address']->updated_at, I18N::getDateFormat())
            ]);
        }

        $this->setItems($items);
    }
}