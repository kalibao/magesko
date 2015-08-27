<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\third;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\third\Third;
use kalibao\common\models\third\ThirdRoleI18n;

/**
 * This is the model class for table "third_role".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Third[] $thirds
 * @property ThirdRoleI18n[] $thirdRoleI18ns
 *
 * @package kalibao\common\models\third
 * @version 1.0
 */
class ThirdRole extends \yii\db\ActiveRecord
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
        return 'third_role';
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
    public function getThirds()
    {
        return $this->hasMany(Third::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThirdRoleI18ns()
    {
        return $this->hasMany(ThirdRoleI18n::className(), ['third_role_id' => 'id']);
    }
}
