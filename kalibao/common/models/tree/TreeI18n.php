<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\tree;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\tree\Tree;

/**
 * This is the model class for table "tree_i18n".
 *
 * @property integer $tree_id
 * @property string $i18n_id
 * @property string $label
 * @property string $description
 *
 * @property Language $i18n
 * @property Tree $tree
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class TreeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'label', 'description'
            ],
            'update' => [
                'label', 'description'
            ],
            'translate' => [
                'label', 'description'
            ],
            'beforeInsert' => [
                'label', 'description'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['tree_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 16],
            [['label'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tree_id' => Yii::t('kalibao.backend','Tree ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'label' => Yii::t('kalibao.backend','name of the tree'),
            'description' => Yii::t('kalibao.backend','description for the tree'),
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
    public function getTree()
    {
        return $this->hasOne(Tree::className(), ['id' => 'tree_id']);
    }
}
