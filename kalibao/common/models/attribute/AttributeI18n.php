<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\attribute;

use Yii;
use kalibao\common\models\attribute\Attribute;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "attribute_i18n".
 *
 * @property integer $attribute_id
 * @property string $i18n_id
 * @property string $value
 *
 * @property Attribute $attributeModel
 * @property Language $i18n
 *
 * @package kalibao\common\models\attribute
 * @version 1.0
 */
class AttributeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'value'
            ],
            'update' => [
                'value'
            ],
            'translate' => [
                'value'
            ],
            'beforeInsert' => [
                'value'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['attribute_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 10],
            [['value'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attribute_id' => Yii::t('kalibao.backend','label_attribute_id'),
            'i18n_id' => Yii::t('kalibao.backend','label_i18n_id'),
            'value' => Yii::t('kalibao.backend','label_attribute_value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeModel()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
