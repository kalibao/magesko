<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\person;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\person\Person;
use kalibao\common\models\person\PersonGenderI18n;

/**
 * This is the model class for table "person_gender".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Person[] $people
 * @property PersonGenderI18n[] $personGenderI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class PersonGender extends \yii\db\ActiveRecord
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
        return 'person_gender';
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
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['gender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonGenderI18ns()
    {
        return $this->hasMany(PersonGenderI18n::className(), ['gender_id' => 'id']);
    }
}
