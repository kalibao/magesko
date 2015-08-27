<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\sheet;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\sheetType\SheetType;
use kalibao\common\models\branch\BranchI18n;
use kalibao\common\models\sheetType\SheetTypeI18n;

/**
 * This is the model class for table "sheet".
 *
 * @property integer $id
 * @property integer $sheet_type_id
 * @property integer $branch_id
 * @property integer $primary_key
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Branch $branch
 * @property SheetType $sheetType
 * @property BranchI18n[] $branchI18ns
 * @property SheetTypeI18n[] $sheetTypeI18ns
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class Sheet extends \yii\db\ActiveRecord
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
        return 'sheet';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'sheet_type_id', 'branch_id', 'primary_key'
            ],
            'update' => [
                'sheet_type_id', 'branch_id', 'primary_key'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'branch_id'], 'required'],
            [['sheet_type_id', 'branch_id', 'primary_key'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'sheet_type_id' => Yii::t('kalibao.backend','Sheet Type ID'),
            'branch_id' => Yii::t('kalibao.backend','Branch ID'),
            'primary_key' => Yii::t('kalibao.backend','value of the primary key for the attached entity'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
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
    public function getBranchI18ns()
    {
        return $this->hasMany(BranchI18n::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetTypeI18ns()
    {
        return $this->hasMany(SheetTypeI18n::className(), ['sheet_type_id' => 'sheet_type_id']);
    }
}
