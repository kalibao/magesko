<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\sheetType;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\sheet\Sheet;
use kalibao\common\models\sheetType\SheetTypeI18n;

/**
 * This is the model class for table "sheet_type".
 *
 * @property integer $id
 * @property string $url_pick
 * @property string $table
 * @property string $url_zoom_front
 * @property string $url_zoom_back
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Sheet[] $sheets
 * @property SheetTypeI18n[] $sheetTypeI18ns
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class SheetType extends \yii\db\ActiveRecord
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
        return 'sheet_type';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'url_pick', 'table', 'url_zoom_front', 'url_zoom_back'
            ],
            'update' => [
                'url_pick', 'table', 'url_zoom_front', 'url_zoom_back'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_pick', 'url_zoom_front', 'url_zoom_back'], 'string', 'max' => 250],
            [['table'], 'required'],
            [['table'], 'string', 'max' => 64],
            [['table'], 'in', 'range' => Yii::$app->db->schema->getTableNames()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'url_pick' => Yii::t('kalibao.backend','url of the edit page for the entity'),
            'table' => Yii::t('kalibao.backend','name of the table of the entity'),
            'url_zoom_front' => Yii::t('kalibao.backend','url of the entity in front office'),
            'url_zoom_back' => Yii::t('kalibao.backend','url of the entity in back office'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheets()
    {
        return $this->hasMany(Sheet::className(), ['sheet_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetTypeI18ns()
    {
        return $this->hasMany(SheetTypeI18n::className(), ['sheet_type_id' => 'id']);
    }
}
