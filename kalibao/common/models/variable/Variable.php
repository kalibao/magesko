<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\variable;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\variableGroup\VariableGroup;
use kalibao\common\models\variableGroup\VariableGroupI18n;

/**
 * This is the model class for table "variable".
 *
 * @property integer $id
 * @property integer $variable_group_id
 * @property string $name
 * @property string $val
 * @property string $created_at
 * @property string $updated_at
 *
 * @property VariableGroup $variableGroup
 * @property VariableI18n[] $variableI18ns
 * @property VariableGroupI18n[] $variableGroupI18ns
 *
 * @package kalibao\common\models\variable
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Variable extends \yii\db\ActiveRecord
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
        return 'variable';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['variable_group_id', 'name', 'val'],
            'update' => ['variable_group_id', 'name', 'val'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variable_group_id', 'name', 'val'], 'required'],
            [['variable_group_id'], 'integer'],
            [['val'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['variable_group_id', 'name'], 'unique', 'targetAttribute' => ['variable_group_id', 'name'], 'message' => Yii::t('kalibao', 'The combination of Variable Group ID and Name has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'variable_group_id' => Yii::t('kalibao','variable:variable_group_id'),
            'name' => Yii::t('kalibao','variable:name'),
            'val' => Yii::t('kalibao','variable:val'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariableGroup()
    {
        return $this->hasOne(VariableGroup::className(), ['id' => 'variable_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariableI18ns()
    {
        return $this->hasMany(VariableI18n::className(), ['variable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariableGroupI18ns()
    {
        return $this->hasMany(VariableGroupI18n::className(), ['variable_group_id' => 'variable_group_id']);
    }
}
