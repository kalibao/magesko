<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\company;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\company\CompanyType;

/**
 * This is the model class for table "company_type_i18n".
 *
 * @property integer $company_type_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property CompanyType $companyType
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class CompanyTypeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_type_i18n';
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
            [['company_type_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['company_type_id'], 'integer'],
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
            'company_type_id' => Yii::t('kalibao.backend','model:id'),
            'i18n_id' => Yii::t('kalibao.backend','model:i18n_id'),
            'title' => Yii::t('kalibao.backend','model:title'),
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
    public function getCompanyType()
    {
        return $this->hasOne(CompanyType::className(), ['id' => 'company_type_id']);
    }
}
