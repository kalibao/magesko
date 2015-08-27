<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\company;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\company\Company;
use kalibao\common\models\person\Person;

/**
 * This is the model class for table "company_contact".
 *
 * @property integer $company_id
 * @property integer $person_id
 * @property integer $is_primary
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
 * @property Person $person
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class CompanyContact extends \yii\db\ActiveRecord
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
        return 'company_contact';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'company_id', 'person_id', 'is_primary'
            ],
            'update' => [
                'company_id', 'person_id', 'is_primary'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'person_id'], 'required'],
            [['company_id', 'person_id'], 'integer'],
            [['is_primary'], 'in', 'range' => [0, 1]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => Yii::t('kalibao.backend','company:company_id'),
            'person_id' => Yii::t('kalibao.backend','company:person_id'),
            'is_primary' => Yii::t('kalibao.backend','company:is_primary'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['third_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['third_id' => 'person_id']);
    }
}
