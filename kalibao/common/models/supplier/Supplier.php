<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\supplier;

use Yii;
use kalibao\common\models\logisticStrategy\LogisticStrategy;
use kalibao\common\models\product\Product;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $id
 * @property string $name
 *
 * @property LogisticStrategy[] $logisticStrategies
 * @property Product[] $products
 *
 * @package kalibao\common\models\supplier
 * @version 1.0
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'name'
            ],
            'update' => [
                'name'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','id of the supplier'),
            'name' => Yii::t('kalibao.backend','name of the supplier'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogisticStrategies()
    {
        return $this->hasMany(LogisticStrategy::className(), ['supplier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['supplier_id' => 'id']);
    }
}
