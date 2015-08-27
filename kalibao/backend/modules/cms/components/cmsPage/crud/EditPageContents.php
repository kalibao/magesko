<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsPage\crud;

use Yii;
use yii\base\Object;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
use kalibao\common\models\cmsLayout\CmsLayoutI18n;

/**
 * Class EditPageContents
 *
 * @package kalibao\backend\modules\cms\components\cmsPage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class EditPageContents extends Object
{
    /**
     * @var \yii\db\ActiveRecord[] Models
     */
    protected $models;

    /**
     * @var string[] List of items
     */
    protected $items;

    /**
     * @var string Language
     */
    protected $language;

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

        $items = [];

        foreach ($models['pageContents'] as $index => $pageContent) {
            $items['pageContents'][$index] = new InputField([
                'model' => $pageContent['i18n'],
                'label' => Yii::t('kalibao.backend', 'cms_page_container_index') . ' ' . $index,
                'attribute' => 'content',
                'type' => 'activeTextarea',
                'options' => [
                    'id' => false,
                    'name' => $pageContent['i18n']->formName(). '[' .$index. '][content]',
                    'class' => 'form-control input-sm wysiwyg-textarea',
                    'placeholder' => $pageContent['i18n']->getAttributeLabel('content'),
                    'data-ckeditor-filebrowser-browse-url' => Url::to(['cms-image/list', 'mode' => 'explorer']),
                    'data-ckeditor-language' => $language
                ]
            ]);
        }

        $this->setItems($items);
    }

    /**
     * Get model
     * @return \yii\db\ActiveRecord[]
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param \yii\db\ActiveRecord $models
     */
    public function setModels($models)
    {
        $this->models = $models;
    }

    /**
     * @return string[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
}