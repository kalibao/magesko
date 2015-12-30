<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\tax;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\taxCountry\TaxCountry;
use kalibao\common\models\tax\TaxI18n;

/**
 * This is the model class for table "tax".
 *
 * @property integer $id
 * @property string $rate
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TaxCountry[] $taxCountries
 * @property TaxI18n[] $taxI18ns
 *
 * @package kalibao\common\models\tax
 * @version 1.0
 */
class Tax extends \yii\db\ActiveRecord
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
        return 'tax';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'id', 'rate'
            ],
            'update' => [
                'id', 'rate'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rate'], 'required'],
            [['id'], 'integer'],
            [['rate'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'rate' => Yii::t('kalibao.backend','Rate'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxCountries()
    {
        return $this->hasMany(TaxCountry::className(), ['tax_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxI18ns()
    {
        return $this->hasMany(TaxI18n::className(), ['tax_id' => 'id']);
    }
}
