<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsPage;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsLayout\CmsLayout;
use kalibao\common\models\cmsLayout\CmsLayoutI18n;
use kalibao\common\models\cmsPageContent\CmsPageContent;

/**
 * This is the model class for table "cms_page".
 *
 * @property integer $id
 * @property integer $activated
 * @property integer $cache_duration
 * @property integer $cms_layout_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsLayout $cmsLayout
 * @property CmsPageContent[] $cmsPageContents
 * @property CmsPageI18n[] $cmsPageI18ns
 * @property CmsLayoutI18n[] $cmsLayoutI18ns
 *
 * @package kalibao\common\models\cmsPage
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsPage extends \yii\db\ActiveRecord
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

    public function init()
    {
        if ($this->scenario === 'insert') {
            $this->cache_duration = 3600;
            $this->activated = 1;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'activated', 'cache_duration', 'cms_layout_id'
            ],
            'update' => [
                'activated', 'cache_duration', 'cms_layout_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activated'], 'in', 'range' => [0, 1]],
            [['cache_duration', 'cms_layout_id'], 'required'],
            [['cache_duration', 'cms_layout_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'activated' => Yii::t('kalibao','model:activated'),
            'cache_duration' => Yii::t('kalibao','cms_page:cache_duration'),
            'cms_layout_id' => Yii::t('kalibao','cms_page:cms_layout_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsLayout()
    {
        return $this->hasOne(CmsLayout::className(), ['id' => 'cms_layout_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPageContents()
    {
        return $this->hasMany(CmsPageContent::className(), ['cms_page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPageI18ns()
    {
        return $this->hasMany(CmsPageI18n::className(), ['cms_page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsLayoutI18ns()
    {
        return $this->hasMany(CmsLayoutI18n::className(), ['cms_layout_id' => 'cms_layout_id']);
    }
}
