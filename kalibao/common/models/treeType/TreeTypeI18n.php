<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\treeType;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\treeType\TreeType;

/**
 * This is the model class for table "tree_type_i18n".
 *
 * @property integer $tree_type_id
 * @property string $i18n_id
 * @property string $label
 *
 * @property Language $i18n
 * @property TreeType $treeType
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class TreeTypeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree_type_i18n';
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
            [['tree_type_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['tree_type_id'], 'integer'],
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
            'tree_type_id' => Yii::t('kalibao.backend','Tree Type ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'label' => Yii::t('kalibao.backend','Label'),
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
    public function getTreeType()
    {
        return $this->hasOne(TreeType::className(), ['id' => 'tree_type_id']);
    }
}
