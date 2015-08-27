<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\third;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\third\ThirdRole;

/**
 * This is the model class for table "third_role_i18n".
 *
 * @property integer $third_role_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property ThirdRole $thirdRole
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class ThirdRoleI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'third_role_i18n';
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
            [['third_role_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['third_role_id'], 'integer'],
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
            'third_role_id' => Yii::t('kalibao.backend','model:id'),
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
    public function getThirdRole()
    {
        return $this->hasOne(ThirdRole::className(), ['id' => 'third_role_id']);
    }
}
