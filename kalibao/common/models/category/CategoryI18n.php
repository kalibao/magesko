<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\category;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\category\Category;

/**
 * This is the model class for table "category_i18n".
 *
 * @property integer $category_id
 * @property string $i18n_id
 * @property string $title
 * @property string $description
 *
 * @property Language $i18n
 * @property Category $category
 *
 * @package kalibao\common\models\category
 * @version 1.0
 */
class CategoryI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'title', 'description'
            ],
            'update' => [
                'title', 'description'
            ],
            'translate' => [
                'title', 'description'
            ],
            'beforeInsert' => [
                'title', 'description'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['category_id'], 'integer'],
            [['i18n_id'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('kalibao.backend','label_category_id'),
            'i18n_id' => Yii::t('kalibao.backend','label_i18n_id'),
            'title' => Yii::t('kalibao.backend','label_category_title'),
            'description' => Yii::t('kalibao.backend','label_category_description'),
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
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
