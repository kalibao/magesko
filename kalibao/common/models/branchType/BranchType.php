<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\branchType;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\branchType\BranchTypeI18n;

/**
 * This is the model class for table "branch_type".
 *
 * @property integer $id
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Branch[] $branches
 * @property BranchTypeI18n[] $branchTypeI18ns
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class BranchType extends \yii\db\ActiveRecord
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
        return 'branch_type';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'url'
            ],
            'update' => [
                'url'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'url' => Yii::t('kalibao.backend','contains the url for the branch type'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['branch_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchTypeI18ns()
    {
        return $this->hasMany(BranchTypeI18n::className(), ['branch_type_id' => 'id']);
    }
}
