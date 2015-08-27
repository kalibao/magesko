<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsPage\crud;

use Yii;
use kalibao\common\components\crud\InputField;
use yii\helpers\Url;

/**
 * Class Translate
 *
 * @package kalibao\backend\modules\cms\components\cmsPage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Translate extends \kalibao\common\components\crud\Translate
{
    /**
     * @var integer Page content number
     */
    public $pageContentNumber;

    /**
     * @var \kalibao\common\models\cmsPageContent\CmsPageContentI18n Page content model
     */
    public $pageContentModel;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // model
        $model = $this->getModel();

        // language
        $language = $this->getLanguage();

        // set items
        $items = [];

        $items['title'] = new InputField([
            'model' => $model,
            'attribute' => 'title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('title'),
            ]
        ]);

        $items['slug'] = new InputField([
            'model' => $model,
            'attribute' => 'slug',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm active-slug',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('slug'),
            ]
        ]);

        $items['html_title'] = new InputField([
            'model' => $model,
            'attribute' => 'html_title',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('html_title'),
            ]
        ]);

        $items['html_description'] = new InputField([
            'model' => $model,
            'attribute' => 'html_description',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $model->getAttributeLabel('html_description'),
            ]
        ]);

        $items['html_keywords'] = new InputField([
            'model' => $model,
            'attribute' => 'html_keywords',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $model->getAttributeLabel('html_keywords'),
            ]
        ]);

        for ($i = 1; $i <= $this->pageContentNumber; ++$i) {
            $items['content_' . $i] = new InputField([
                'model' => $this->pageContentModel,
                'attribute' => 'content',
                'label' => Yii::t('kalibao.backend', 'cms_page_container_index') . ' ' . $i,
                'type' => 'activeTextarea',
                'options' => [
                    'class' => 'form-control input-sm wysiwyg-textarea',
                    'data-ckeditor-filebrowser-browse-url' => Url::to(['cms-image/list', 'mode' => 'explorer']),
                    'data-ckeditor-language' => $this->language,
                    'data-index' => $i,
                    'maxlength' => true,
                ]
            ]);
        }

        $this->setItems($items);
    }
}