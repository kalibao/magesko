<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\tax;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\tax\Tax;

/**
 * This is the model class for table "tax_i18n".
 *
 * @property integer $tax_id
 * @property string $i18n_id
 * @property string $name
 *
 * @property Language $i18n
 * @property Tax $tax
 *
 * @package kalibao\common\models\tax
 * @version 1.0
 */
class TaxI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tax_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'name'
            ],
            'update' => [
                'name'
            ],
            'translate' => [
                'name'
            ],
            'beforeInsert' => [
                'name'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tax_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['tax_id'], 'integer'],
            [['name'], 'required'],
            [['i18n_id'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tax_id' => Yii::t('kalibao.backend','Tax ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'name' => Yii::t('kalibao.backend','Name'),
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
    public function getTax()
    {
        return $this->hasOne(Tax::className(), ['id' => 'tax_id']);
    }
}
