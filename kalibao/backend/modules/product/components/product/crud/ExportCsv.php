<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\product\components\product\crud;

use Yii;
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package kalibao\backend\modules\product\components\product\crud
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
            'exclude_discount_code' => true,
            'force_secure' => true,
            'archived' => true,
            'top_product' => true,
            'exclude_from_google' => true,
            'link_brand_product' => true,
            'link_product_test' => true,
            'available' => true,
            'available_date' => true,
            'product_i18n_name' => true,
            'brand_name' => true,
            'supplier_name' => true,
            'base_price' => true,
            'is_pack' => true,
            'product_i18n_short_description' => true,
            'product_i18n_long_description' => true,
            'product_i18n_comment' => true,
            'product_i18n_page_title' => true,
            'product_i18n_name' => true,
            'product_i18n_infos_shipping' => true,
            'product_i18n_meta_description' => true,
            'product_i18n_meta_keywords' => true,
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
            $model->exclude_discount_code,
            $model->force_secure,
            $model->archived,
            $model->top_product,
            $model->exclude_from_google,
            $model->link_brand_product,
            $model->link_product_test,
            $model->available,
            Yii::$app->formatter->asDatetime($model->available_date, I18N::getDateFormat()),
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->name : '',
            isset($model->brand) ? $model->brand->name : '',
            isset($model->supplier) ? $model->supplier->name : '',
            $model->base_price,
            $model->is_pack,
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->short_description : '',
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->long_description : '',
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->comment : '',
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->page_title : '',
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->name : '',
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->infos_shipping : '',
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->meta_description : '',
            isset($model->productI18ns[0]) ? $model->productI18ns[0]->meta_keywords : '',
            Yii::$app->formatter->asDatetime($model->created_at, I18N::getDateFormat()),
            Yii::$app->formatter->asDatetime($model->updated_at, I18N::getDateFormat()),
        ];
    }
}