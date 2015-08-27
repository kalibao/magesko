<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\branchType;

use Yii;
use kalibao\common\models\branchType\BranchType;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "branch_type_i18n".
 *
 * @property integer $branch_type_id
 * @property string $i18n_id
 * @property string $label
 *
 * @property BranchType $branchType
 * @property Language $i18n
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class BranchTypeI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branch_type_i18n';
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
            [['branch_type_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['branch_type_id'], 'integer'],
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
            'branch_type_id' => Yii::t('kalibao.backend','Branch Type ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'label' => Yii::t('kalibao.backend','name of the branch'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchType()
    {
        return $this->hasOne(BranchType::className(), ['id' => 'branch_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
