<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\treeType;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\tree\Tree;
use kalibao\common\models\treeType\TreeTypeI18n;

/**
 * This is the model class for table "tree_type".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Tree[] $trees
 * @property TreeTypeI18n[] $treeTypeI18ns
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class TreeType extends \yii\db\ActiveRecord
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
        return 'tree_type';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                
            ],
            'update' => [
                
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','ID'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrees()
    {
        return $this->hasMany(Tree::className(), ['tree_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeTypeI18ns()
    {
        return $this->hasMany(TreeTypeI18n::className(), ['tree_type_id' => 'id']);
    }
}
