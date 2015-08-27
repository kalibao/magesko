<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\logisticStrategy;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\logisticStrategy\LogisticStrategy;

/**
 * This is the model class for table "logistic_strategy_i18n".
 *
 * @property integer $logistic_strategy_id
 * @property string $i18n_id
 * @property string $message
 *
 * @property Language $i18n
 * @property LogisticStrategy $logisticStrategy
 *
 * @package kalibao\common\models\logisticStrategy
 * @version 1.0
 */
class LogisticStrategyI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logistic_strategy_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'message'
            ],
            'update' => [
                'message'
            ],
            'translate' => [
                'message'
            ],
            'beforeInsert' => [
                'message'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['logistic_strategy_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['logistic_strategy_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 16],
            [['message'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'logistic_strategy_id' => Yii::t('kalibao.backend','label_logistic_strategy_id'),
            'i18n_id' => Yii::t('kalibao.backend','label_i18n_id'),
            'message' => Yii::t('kalibao.backend','label_logistic_strategy_message'),
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
    public function getLogisticStrategy()
    {
        return $this->hasOne(LogisticStrategy::className(), ['id' => 'logistic_strategy_id']);
    }
}
