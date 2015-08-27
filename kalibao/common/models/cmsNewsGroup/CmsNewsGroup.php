<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsNewsGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsNews\CmsNews;

/**
 * This is the model class for table "cms_news_group".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsNews[] $cmsNews
 * @property CmsNewsGroupI18n[] $cmsNewsGroupI18ns
 *
 * @package kalibao\common\models\cmsNewsGroup
 * @version 1.0
 */
class CmsNewsGroup extends \yii\db\ActiveRecord
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
        return 'cms_news_group';
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
            'id' => Yii::t('kalibao','model:id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNews()
    {
        return $this->hasMany(CmsNews::className(), ['cms_news_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNewsGroupI18ns()
    {
        return $this->hasMany(CmsNewsGroupI18n::className(), ['cms_news_group_id' => 'id']);
    }
}
