<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\media\components\media\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\media\components\media\crud
 * @version 1.0
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
            'file' => true,
            'media_type_i18n_title' => true,
            'media_i18n_title' => true,
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
            ($model->file != '')
                ?
                    $this->uploadConfig[(new \ReflectionClass($this->model))
                        ->getParentClass()->name]['file']['baseUrl'] . '/' . $this->model->file
                :
                    ''
            ,
            isset($model->mediaTypeI18ns[0]) ? $model->mediaTypeI18ns[0]->title : '',
            isset($model->mediaI18ns[0]) ? $model->mediaI18ns[0]->title : '',
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}