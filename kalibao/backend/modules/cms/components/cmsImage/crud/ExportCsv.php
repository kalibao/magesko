<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsImage\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\cms\components\cmsImage\crud
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
            'cms_image_i18n_title' => true,
            'cms_image_group_i18n_title' => true,
            'file_path' => true,
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
            isset($model->cmsImageI18ns[0]) ? $model->cmsImageI18ns[0]->title : '',
            isset($model->cmsImageGroupI18ns[0]) ? $model->cmsImageGroupI18ns[0]->title : '',
            ($model->file_path != '')
                ?
                    $this->uploadConfig[(new \ReflectionClass($this->model))
                        ->getParentClass()->name]['file_path']['baseUrl'] . '/' . $this->model->file_path
                :
                    ''
            ,
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}