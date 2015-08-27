<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\company;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\company\Company;
use kalibao\common\models\company\CompanyTypeI18n;

/**
 * This is the model class for table "company_type".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company[] $companies
 * @property CompanyTypeI18n[] $companyTypeI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class CompanyType extends \yii\db\ActiveRecord
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
        return 'company_type';
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
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['company_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTypeI18ns()
    {
        return $this->hasMany(CompanyTypeI18n::className(), ['company_type_id' => 'id']);
    }
}
