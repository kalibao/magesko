<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsNews;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsNewsGroup\CmsNewsGroup;
use kalibao\common\models\cmsNewsGroup\CmsNewsGroupI18n;

/**
 * This is the model class for table "cms_news".
 *
 * @property integer $id
 * @property integer $cms_news_group_id
 * @property integer $activated
 * @property string $published_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsNewsGroup $cmsNewsGroup
 * @property CmsNewsI18n[] $cmsNewsI18ns
 * @property CmsNewsGroupI18n[] $cmsNewsGroupI18ns
 *
 * @package kalibao\common\models\cmsNews
 * @version 1.0
 */
class CmsNews extends \yii\db\ActiveRecord
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
        return 'cms_news';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'cms_news_group_id', 'activated', 'published_at'
            ],
            'update' => [
                'cms_news_group_id', 'activated', 'published_at'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_news_group_id', 'activated', 'published_at'], 'required'],
            [['cms_news_group_id'], 'integer'],
            [['activated'], 'in', 'range' => [0, 1]],
            [['published_at'], 'date', 'format' => 'yyyy-MM-dd']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'cms_news_group_id' => Yii::t('kalibao','cms_news:cms_news_group_id'),
            'activated' => Yii::t('kalibao','model:activated'),
            'published_at' => Yii::t('kalibao','cms_news:published_at'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNewsGroup()
    {
        return $this->hasOne(CmsNewsGroup::className(), ['id' => 'cms_news_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNewsI18ns()
    {
        return $this->hasMany(CmsNewsI18n::className(), ['cms_news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNewsGroupI18ns()
    {
        return $this->hasMany(CmsNewsGroupI18n::className(), ['cms_news_group_id' => 'cms_news_group_id']);
    }
}
