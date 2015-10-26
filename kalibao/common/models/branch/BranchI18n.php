<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\branch;

use Yii;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "branch_i18n".
 *
 * @property integer $branch_id
 * @property string $i18n_id
 * @property string $label
 * @property string $description
 * @property string $url
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $h1_tag
 *
 * @property Branch $branch
 * @property Language $i18n
 *
 * @package kalibao\common\models\tree
 * @version 1.0
 */
class BranchI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branch_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'label', 'description', 'url', 'meta_title', 'meta_description', 'meta_keywords', 'h1_tag'
            ],
            'update' => [
                'label', 'description', 'url', 'meta_title', 'meta_description', 'meta_keywords', 'h1_tag'
            ],
            'translate' => [
                'label', 'description', 'url', 'meta_title', 'meta_description', 'meta_keywords', 'h1_tag'
            ],
            'beforeInsert' => [
                'label', 'description', 'url', 'meta_title', 'meta_description', 'meta_keywords', 'h1_tag'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['branch_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 16],
            [['label'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['url'], 'string', 'max' => 250],
            [['meta_title'], 'string', 'max' => 1000],
            [['meta_description', 'meta_keywords', 'h1_tag'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'branch_id' => Yii::t('kalibao.backend','branch_i18n:branch_id'),
            'i18n_id' => Yii::t('kalibao.backend','branch_i18n:i18n_id'),
            'label' => Yii::t('kalibao.backend','branch_i18n:label'),
            'description' => Yii::t('kalibao.backend','branch_i18n:description'),
            'url' => Yii::t('kalibao.backend','branch_i18n:url'),
            'meta_title' => Yii::t('kalibao.backend','branch_i18n:meta_title'),
            'meta_description' => Yii::t('kalibao.backend','branch_i18n:meta_description'),
            'meta_keywords' => Yii::t('kalibao.backend','branch_i18n:meta_keywords'),
            'h1_tag' => Yii::t('kalibao.backend','branch_i18n:h1_tag'),
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
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
