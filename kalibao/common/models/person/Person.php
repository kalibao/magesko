<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\person;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\mailSendingRole\MailSendingRole;
use kalibao\common\models\person\PersonGender;
use kalibao\common\models\third\Third;
use kalibao\common\models\language\Language;
use kalibao\common\models\user\User;
use kalibao\common\models\company\CompanyContact;
use kalibao\common\models\person\PersonGenderI18n;
use kalibao\common\models\language\LanguageI18n;

/**
 * This is the model class for table "person".
 *
 * @property integer $third_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $default_language
 * @property integer $user_id
 * @property integer $gender_id
 * @property string $phone_1
 * @property string $phone_2
 * @property string $fax
 * @property string $website
 * @property string $birthday
 * @property string $skype
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MailSendingRole[] $mailSendingRoles
 * @property PersonGender $gender
 * @property Third $third
 * @property Language $defaultLanguage
 * @property User $user
 * @property CompanyContact[] $societyContacts
 * @property PersonGenderI18n[] $personGenderI18ns
 * @property LanguageI18n[] $languageI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class Person extends \yii\db\ActiveRecord
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
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'third_id', 'first_name', 'last_name', 'email', 'default_language', 'user_id', 'gender_id', 'phone_1', 'phone_2', 'fax', 'website', 'birthday', 'skype'
            ],
            'update' => [
                'third_id', 'first_name', 'last_name', 'email', 'default_language', 'user_id', 'gender_id', 'phone_1', 'phone_2', 'fax', 'website', 'birthday', 'skype'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['third_id', 'first_name', 'last_name', 'email', 'default_language'], 'required'],
            [['third_id', 'user_id', 'gender_id'], 'integer'],
            [['birthday'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 255],
            [['default_language'], 'string', 'max' => 16],
            [['phone_1', 'phone_2', 'fax', 'website', 'skype'], 'string', 'max' => 45],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'third_id' => Yii::t('kalibao.backend','person:id'),
            'first_name' => Yii::t('kalibao.backend','person:first_name'),
            'last_name' => Yii::t('kalibao.backend','person:last_name'),
            'email' => Yii::t('kalibao.backend','person:email'),
            'default_language' => Yii::t('kalibao.backend','person:default_language'),
            'user_id' => Yii::t('kalibao.backend','person:user_id'),
            'gender_id' => Yii::t('kalibao.backend','person:gender_id'),
            'phone_1' => Yii::t('kalibao.backend','person:phone_1'),
            'phone_2' => Yii::t('kalibao.backend','person:phone_2'),
            'fax' => Yii::t('kalibao.backend','person:fax_number'),
            'website' => Yii::t('kalibao.backend','person:website'),
            'birthday' => Yii::t('kalibao.backend','person:birthday'),
            'skype' => Yii::t('kalibao.backend','person:skype'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailSendingRoles()
    {
        return $this->hasMany(MailSendingRole::className(), ['person_id' => 'third_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(PersonGender::className(), ['id' => 'gender_id']);
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
    public function getDefaultLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'default_language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyContacts()
    {
        return $this->hasMany(CompanyContact::className(), ['person_id' => 'third_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonGenderI18ns()
    {
        return $this->hasMany(PersonGenderI18n::className(), ['gender_id' => 'gender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageI18ns()
    {
        return $this->hasMany(LanguageI18n::className(), ['language_id' => 'default_language']);
    }

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
