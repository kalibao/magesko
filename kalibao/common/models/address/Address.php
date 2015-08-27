<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\address;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\address\AddressType;
use kalibao\common\models\third\Third;
use kalibao\common\models\address\AddressTypeI18n;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $third_id
 * @property integer $address_type_id
 * @property string $label
 * @property string $place_1
 * @property string $place_2
 * @property string $street_number
 * @property string $door_code
 * @property string $zip_code
 * @property string $city
 * @property string $country
 * @property integer $is_primary
 * @property string $note
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AddressType $addressType
 * @property Third $third
 * @property AddressTypeI18n[] $addressTypeI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class Address extends \yii\db\ActiveRecord
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
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'third_id', 'address_type_id', 'label', 'place_1', 'place_2', 'street_number', 'door_code', 'zip_code', 'city', 'country', 'is_primary', 'note'
            ],
            'update' => [
                'third_id', 'address_type_id', 'label', 'place_1', 'place_2', 'street_number', 'door_code', 'zip_code', 'city', 'country', 'is_primary', 'note'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['third_id', 'address_type_id'], 'required'],
            [['third_id', 'address_type_id'], 'integer'],
            [['is_primary'], 'in', 'range' => [0, 1]],
            [['label', 'place_1', 'place_2', 'street_number', 'door_code', 'zip_code', 'city', 'country'], 'string', 'max' => 45],
            [['note'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','model:id'),
            'third_id' => Yii::t('kalibao.backend','address:third_id'),
            'address_type_id' => Yii::t('kalibao.backend','address:address_type_id'),
            'label' => Yii::t('kalibao.backend','address:label'),
            'place_1' => Yii::t('kalibao.backend','address:place_1'),
            'place_2' => Yii::t('kalibao.backend','address:place_2'),
            'street_number' => Yii::t('kalibao.backend','address:street_number'),
            'door_code' => Yii::t('kalibao.backend','address:door_code'),
            'zip_code' => Yii::t('kalibao.backend','address:zip_code'),
            'city' => Yii::t('kalibao.backend','address:city'),
            'country' => Yii::t('kalibao.backend','address:country'),
            'is_primary' => Yii::t('kalibao.backend','address:primary'),
            'note' => Yii::t('kalibao.backend','model:note'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressType()
    {
        return $this->hasOne(AddressType::className(), ['id' => 'address_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThird()
    {
        return $this->hasOne(Third::className(), ['id' => 'third_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressTypeI18ns()
    {
        return $this->hasMany(AddressTypeI18n::className(), ['address_type_id' => 'address_type_id']);
    }
}
