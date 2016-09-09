<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\taxCountry;

use Yii;
use kalibao\common\models\country\Country;
use kalibao\common\models\tax\Tax;
use kalibao\common\models\country\CountryI18n;
use kalibao\common\models\tax\TaxI18n;

/**
 * This is the model class for table "tax_country".
 *
 * @property integer $tax_id
 * @property string $country_id
 *
 * @property Country $country
 * @property Tax $tax
 * @property CountryI18n[] $countryI18ns
 * @property TaxI18n[] $taxI18ns
 *
 * @package kalibao\common\models\taxCountry
 * @version 1.0
 */
class TaxCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tax_country';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'tax_id', 'country_id'
            ],
            'update' => [
                'tax_id', 'country_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tax_id', 'country_id'], 'required'],
            [['tax_id'], 'integer'],
            [['country_id'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tax_id' => Yii::t('kalibao.backend','Tax ID'),
            'country_id' => Yii::t('kalibao.backend','Country ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTax()
    {
        return $this->hasOne(Tax::className(), ['id' => 'tax_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryI18ns()
    {
        return $this->hasMany(CountryI18n::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxI18ns()
    {
        return $this->hasMany(TaxI18n::className(), ['tax_id' => 'tax_id']);
    }
}
