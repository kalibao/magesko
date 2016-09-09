<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\country;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\country\Country;

/**
 * This is the model class for table "country_i18n".
 *
 * @property string $country_id
 * @property string $i18n_id
 * @property string $name
 *
 * @property Language $i18n
 * @property Country $country
 *
 * @package kalibao\common\models\country
 * @version 1.0
 */
class CountryI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country_i18n';
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
            'translate' => [
                'name'
            ],
            'beforeInsert' => [
                'name'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['name'], 'required'],
            [['country_id'], 'string', 'max' => 2],
            [['i18n_id'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('kalibao.backend','Country ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'name' => Yii::t('kalibao.backend','Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getAllI18nById()
    {
        $return = [];

        $translations = CountryI18n::findAll(['i18n_id' => Yii::$app->language]);
        foreach ($translations as $translation) {
            $return[$translation->country_id] = $translation->name;
        }

        return $return;
    }
}
