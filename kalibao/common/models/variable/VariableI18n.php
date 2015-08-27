<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\variable;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "variable_i18n".
 *
 * @property integer $variable_id
 * @property string $i18n_id
 * @property string $description
 *
 * @property Variable $variable
 * @property Language $i18n
 *
 * @package kalibao\common\models\variable
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class VariableI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variable_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'description'
            ],
            'update' => [
                'description'
            ],
            'beforeInsert' => [
                'description'
            ],
            'translate' => [
                'description'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variable_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['variable_id'], 'integer'],
            [['description'], 'required'],
            [['description'], 'string'],
            [['i18n_id'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'variable_id' => Yii::t('kalibao.backend','Variable ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'description' => Yii::t('kalibao','model:description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariable()
    {
        return $this->hasOne(Variable::className(), ['id' => 'variable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
