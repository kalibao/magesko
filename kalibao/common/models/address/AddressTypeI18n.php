<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\address;

use Yii;
use kalibao\common\models\address\AddressType;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "address_type_i18n".
 *
 * @property integer $address_type_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property AddressType $addressType
 * @property Language $i18n
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class AddressTypeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_type_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'title'
            ],
            'update' => [
                'title'
            ],
            'translate' => [
                'title'
            ],
            'beforeInsert' => [
                'title'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_type_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['address_type_id'], 'integer'],
            [['title'], 'required'],
            [['i18n_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_type_id' => Yii::t('kalibao.backend','model:id'),
            'i18n_id' => Yii::t('kalibao.backend','model:i18n_id'),
            'title' => Yii::t('kalibao.backend','model:title'),
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
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
