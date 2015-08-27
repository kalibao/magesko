<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\address;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\address\Address;
use kalibao\common\models\address\AddressTypeI18n;

/**
 * This is the model class for table "address_type".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address[] $addresses
 * @property AddressTypeI18n[] $addressTypeI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class AddressType extends \yii\db\ActiveRecord
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
        return 'address_type';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                
            ],
            'update' => [
                
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','model:id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['address_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressTypeI18ns()
    {
        return $this->hasMany(AddressTypeI18n::className(), ['address_type_id' => 'id']);
    }
}
