<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\company;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\company\CompanyType;
use kalibao\common\models\third\Third;
use kalibao\common\models\company\CompanyContact;
use kalibao\common\models\company\CompanyTypeI18n;

/**
 * This is the model class for table "company".
 *
 * @property integer $third_id
 * @property integer $company_type
 * @property string $name
 * @property string $tva_number
 * @property string $naf
 * @property string $siren
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CompanyType $companyType
 * @property Third $third
 * @property CompanyContact[] $companyContacts
 * @property CompanyTypeI18n[] $companyTypeI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class Company extends \yii\db\ActiveRecord
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
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'third_id', 'company_type', 'name', 'tva_number', 'naf', 'siren'
            ],
            'update' => [
                'third_id', 'company_type', 'name', 'tva_number', 'naf', 'siren'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['third_id', 'company_type'], 'required'],
            [['third_id', 'company_type'], 'integer'],
            [['tva_number', 'naf', 'siren', 'name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'third_id' => Yii::t('kalibao.backend','company:third_id'),
            'company_type' => Yii::t('kalibao.backend','company:company_type'),
            'name' => Yii::t('kalibao.backend','company:name'),
            'tva_number' => Yii::t('kalibao.backend','company:intra_number'),
            'naf' => Yii::t('kalibao.backend','company:naf'),
            'siren' => Yii::t('kalibao.backend','company:siren'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyType()
    {
        return $this->hasOne(CompanyType::className(), ['id' => 'company_type']);
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
    public function getCompanyContacts()
    {
        return $this->hasMany(CompanyContact::className(), ['company_id' => 'third_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTypeI18ns()
    {
        return $this->hasMany(CompanyTypeI18n::className(), ['company_type_id' => 'company_type']);
    }
}
