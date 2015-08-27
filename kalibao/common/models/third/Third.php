<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\third;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\address\Address;
use kalibao\common\models\person\Person;
use kalibao\common\models\company\Company;
use kalibao\common\models\third\ThirdRole;
use kalibao\common\models\third\ThirdRoleI18n;

/**
 * This is the model class for table "third".
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $note
 * @property string $created_at
 * @property string $updated_at
 *
 * @property string $name
 *
 * @property Address[] $addresses
 * @property Address $primaryAddress
 * @property Person $person
 * @property Company $society
 * @property ThirdRole $role
 * @property ThirdRoleI18n[] $thirdRoleI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class Third extends \yii\db\ActiveRecord
{
    /**
     * This is the constant for select the interface, this is really important !
     * The value (1,2,...) reflect the id of the role in third_role table.
     * If you add an interface entry your must add the constant corresponding here,
     * in the ThirdController and in the Third{List,Edit}.js
     */
    const PERSON_INTERFACE = 1 ;
    const COMPANY_INTERFACE = 2 ;

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
        return 'third';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'role_id', 'note'
            ],
            'update' => [
                'role_id', 'note'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            [['role_id'], 'integer'],
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
            'role_id' => Yii::t('kalibao.backend','third:role_id'),
            'note' => Yii::t('kalibao.backend','model:note'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
            'name' => Yii::t('kalibao', 'model:name')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['third_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['third_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSociety()
    {
        return $this->hasOne(Company::className(), ['third_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(ThirdRole::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThirdRoleI18ns()
    {
        return $this->hasMany(ThirdRoleI18n::className(), ['third_role_id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterface()
    {
        if ($this->role_id == self::PERSON_INTERFACE)
            return $this->getPerson();
        else if ($this->role_id == self::COMPANY_INTERFACE )
            return $this->getSociety();
    }

    public function getPrimaryAddress()
    {
        return Address::findOne(['third_id' => $this->id, 'is_primary' => 1]);
    }
}
