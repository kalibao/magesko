<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsPage\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\cms\components\cmsPage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ExportCsv extends ActiveRecordCsv
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setHeader([
            '#',
            'cms_page_i18n_title' => true,
            'activated' => true,
            'cache_duration' => true,
            'cms_layout_i18n_name' => true,
            'cms_page_i18n_slug' => true,
            'cms_page_i18n_html_title' => true,
            'cms_page_i18n_html_description' => true,
            'cms_page_i18n_html_keywords' => true,
            'created_at' => true,
            'updated_at' => true,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getRow(ActiveRecord $model)
    {
        return [
            $model->id,
            isset($model->cmsPageI18ns[0]) ? $model->cmsPageI18ns[0]->title : '',
            $model->activated,
            $model->cache_duration,
            isset($model->cmsLayoutI18ns[0]) ? $model->cmsLayoutI18ns[0]->name : '',
            isset($model->cmsPageI18ns[0]) ? $model->cmsPageI18ns[0]->slug : '',
            isset($model->cmsPageI18ns[0]) ? $model->cmsPageI18ns[0]->html_title : '',
            isset($model->cmsPageI18ns[0]) ? $model->cmsPageI18ns[0]->html_description : '',
            isset($model->cmsPageI18ns[0]) ? $model->cmsPageI18ns[0]->html_keywords : '',
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}