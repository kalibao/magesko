<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\discount;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\crossSelling\CrossSelling;
use kalibao\common\models\variant\Variant;

/**
 * This is the model class for table "discount".
 *
 * @property integer $id
 * @property double $percent
 * @property string $start_date
 * @property string $end_date
 * @property double $percent_vip
 * @property string $start_date_vip
 * @property string $end_date_vip
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CrossSelling[] $crossSellings
 * @property Variant[] $variants
 *
 * @package kalibao\common\models\discount
 * @version 1.0
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function ($event) {
                    return date('Y-m-d h:i:s');
                },
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'percent', 'start_date', 'end_date', 'percent_vip', 'start_date_vip', 'end_date_vip'
            ],
            'update' => [
                'percent', 'start_date', 'end_date', 'percent_vip', 'start_date_vip', 'end_date_vip'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['percent', 'percent_vip'], 'number'],
            [['start_date', 'end_date', 'start_date_vip', 'end_date_vip'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','id of the discount'),
            'percent' => Yii::t('kalibao.backend','discount rate in percent'),
            'start_date' => Yii::t('kalibao.backend','begining date of the discount'),
            'end_date' => Yii::t('kalibao.backend','end date of the discount'),
            'percent_vip' => Yii::t('kalibao.backend','discount rate for premium clients in percent'),
            'start_date_vip' => Yii::t('kalibao.backend','begining date of the discount for premium clients'),
            'end_date_vip' => Yii::t('kalibao.backend','end date of the discount for mremium clients'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrossSellings()
    {
        return $this->hasMany(CrossSelling::className(), ['discount_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariants()
    {
        return $this->hasMany(Variant::className(), ['discount_id' => 'id']);
    }
}
