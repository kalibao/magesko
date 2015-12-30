<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\country;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\country\CountryI18n;
use kalibao\common\models\taxCountry\TaxCountry;

/**
 * This is the model class for table "country".
 *
 * @property string $id
 * @property string $iso3
 * @property integer $numcode
 * @property integer $phonecode
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CountryI18n[] $countryI18ns
 * @property TaxCountry[] $taxCountries
 *
 * @package kalibao\common\models\country
 * @version 1.0
 */
class Country extends \yii\db\ActiveRecord
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
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'id', 'iso3', 'numcode', 'phonecode'
            ],
            'update' => [
                'id', 'iso3', 'numcode', 'phonecode'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['numcode', 'phonecode'], 'integer'],
            [['id'], 'string', 'max' => 2],
            [['iso3'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'iso3' => Yii::t('kalibao.backend','Iso3'),
            'numcode' => Yii::t('kalibao.backend','Numcode'),
            'phonecode' => Yii::t('kalibao.backend','Phonecode'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryI18ns()
    {
        return $this->hasMany(CountryI18n::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxCountries()
    {
        return $this->hasMany(TaxCountry::className(), ['country_id' => 'id']);
    }
}
