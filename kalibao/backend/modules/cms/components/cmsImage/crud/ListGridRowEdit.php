<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsImage\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\cmsImageGroup\CmsImageGroupI18n;

/**
 * Class ListGridRowEdit
 *
 * @package kalibao\backend\modules\cms\components\cmsImage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGridRowEdit extends \kalibao\common\components\crud\ListGridRowEdit
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

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

        $items[] = new InputField([
            'model' => $models['i18n'],
            'attribute' => 'title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['main']->getAttributeLabel('title'),
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'cms_image_group_id',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => 'cms_image_group_i18n.title',
                ]),
                'data-add-action' => Url::to('/cms/cms-image-group/create'),
                'data-update-action' => Url::to('/cms/cms-image-group/update'),
                'data-update-argument' => 'id',
                'data-related-field' => '.link_cms_image_group_title',
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['main']->cms_image_group_id) ? CmsImageGroupI18n::findOne([
                    'cms_image_group_id' => $models['main']->cms_image_group_id,
                    'i18n_id' => $language
                ])->title : '',
            ]
        ]);

        $items[] = new InputField([
            'model' => $models['main'],
            'attribute' => 'file_path',
            'type' => 'activeFileInput',
            'options' => [
                'class' => 'input-advanced-uploader',
                'placeholder' => $models['main']->getAttributeLabel('file_path'),
                'data-type-uploader' => $uploadConfig['main']['file_path']['type'],
                'data-img-src' => ($models['main']->file_path != '') ?
                    $uploadConfig['main']['file_path']['baseUrl'] . '/min/'
                    . $models['main']->file_path : '',
                'data-img-size-width' => '300px',
            ]
        ]);


        $this->setItems($items);
    }
}