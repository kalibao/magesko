<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\components\address\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\third\components\address\crud
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
            'third_id' => true,
            'address_type_i18n_title' => true,
            'label' => true,
            'place_1' => true,
            'place_2' => true,
            'street_number' => true,
            'door_code' => true,
            'zip_code' => true,
            'city' => true,
            'country' => true,
            'is_primary' => true,
            'note' => true,
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
            isset($model->third) ? $model->third->id : '',
            isset($model->addressTypeI18ns[0]) ? $model->addressTypeI18ns[0]->title : '',
            $model->label,
            $model->place_1,
            $model->place_2,
            $model->street_number,
            $model->door_code,
            $model->zip_code,
            $model->city,
            $model->country,
            $model->is_primary,
            $model->note,
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}