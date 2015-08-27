<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\variableGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\variable\Variable;

/**
 * This is the model class for table "variable_group".
 *
 * @property integer $id
 * @property string $code
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Variable[] $variables
 * @property VariableGroupI18n[] $variableGroupI18ns
 *
 * @package kalibao\common\models\variableGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class VariableGroup extends \yii\db\ActiveRecord
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
        return 'variable_group';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['code'],
            'update' => ['code'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'trim'],
            [['code'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'code' => Yii::t('kalibao','variable_group:code'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariables()
    {
        return $this->hasMany(Variable::className(), ['variable_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariableGroupI18ns()
    {
        return $this->hasMany(VariableGroupI18n::className(), ['variable_group_id' => 'id']);
    }
}
