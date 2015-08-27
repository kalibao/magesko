<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsNews\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\cms\components\cmsNews\crud
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
            'cms_news_i18n_title' => true,
            'cms_news_group_i18n_title' => true,
            'cms_news_i18n_content' => true,
            'activated' => true,
            'published_at' => true,
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
            isset($model->cmsNewsI18ns[0]) ? $model->cmsNewsI18ns[0]->title : '',
            isset($model->cmsNewsGroupI18ns[0]) ? $model->cmsNewsGroupI18ns[0]->title : '',
            isset($model->cmsNewsI18ns[0]) ? $model->cmsNewsI18ns[0]->content : '',
            $model->activated,
            Yii::$app->formatter->asDatetime($model->published_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}