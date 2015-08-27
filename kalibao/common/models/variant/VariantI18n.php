<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\variant;

use Yii;
use kalibao\common\models\variant\Variant;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "variant_i18n".
 *
 * @property integer $variant_id
 * @property string $i18n_id
 * @property string $description
 *
 * @property Variant $variant
 * @property Language $i18n
 *
 * @package kalibao\common\models\variant
 * @version 1.0
 */
class VariantI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variant_i18n';
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
            'translate' => [
                'description'
            ],
            'beforeInsert' => [
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
            [['variant_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['variant_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 8000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'variant_id' => Yii::t('kalibao.backend','id of the variant'),
            'i18n_id' => Yii::t('kalibao.backend','id of the language'),
            'description' => Yii::t('kalibao.backend','translation for the description of the related variant'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariant()
    {
        return $this->hasOne(Variant::className(), ['product_id' => 'variant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
