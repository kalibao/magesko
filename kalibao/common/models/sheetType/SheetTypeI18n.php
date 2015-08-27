<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\sheetType;

use Yii;
use kalibao\common\models\sheetType\SheetType;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "sheet_type_i18n".
 *
 * @property integer $sheet_type_id
 * @property string $i18n_id
 * @property string $label
 *
 * @property SheetType $sheetType
 * @property Language $i18n
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class SheetTypeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sheet_type_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'label'
            ],
            'update' => [
                'label'
            ],
            'translate' => [
                'label'
            ],
            'beforeInsert' => [
                'label'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['sheet_type_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 16],
            [['label'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sheet_type_id' => Yii::t('kalibao.backend','Sheet Type ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'label' => Yii::t('kalibao.backend','Label'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetType()
    {
        return $this->hasOne(SheetType::className(), ['id' => 'sheet_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
