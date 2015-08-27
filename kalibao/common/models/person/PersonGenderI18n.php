<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\person;

use Yii;
use kalibao\common\models\person\PersonGender;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "person_gender_i18n".
 *
 * @property integer $gender_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property PersonGender $personGender
 * @property Language $i18n
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class PersonGenderI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_gender_i18n';
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
            [['gender_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['gender_id'], 'integer'],
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
            'gender_id' => Yii::t('kalibao.backend','model:id'),
            'i18n_id' => Yii::t('kalibao.backend','model:i18n_id'),
            'title' => Yii::t('kalibao.backend','model:title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonGender()
    {
        return $this->hasOne(PersonGender::className(), ['id' => 'gender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
