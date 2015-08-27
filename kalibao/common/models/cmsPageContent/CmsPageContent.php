<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsPageContent;

use Yii;
use kalibao\common\models\cmsPage\CmsPage;
use kalibao\common\models\cmsPage\CmsPageI18n;

/**
 * This is the model class for table "cms_page_content".
 *
 * @property integer $id
 * @property integer $cms_page_id
 * @property integer $index
 *
 * @property CmsPage $cmsPage
 * @property CmsPageContentI18n[] $cmsPageContentI18ns
 * @property CmsPageI18n[] $cmsPageI18ns
 *
 * @package kalibao\backend\modules\cms\models\cmsPageContent
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsPageContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page_content';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'cms_page_id', 'index'
            ],
            'update' => [
                'cms_page_id', 'index'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_page_id', 'index'], 'required'],
            [['cms_page_id', 'index'], 'integer'],
            [['cms_page_id', 'index'], 'unique', 'targetAttribute' => ['cms_page_id', 'index'], 'message' => Yii::t('kalibao', 'The combination of Cms Page ID and Index has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','model:id'),
            'cms_page_id' => Yii::t('kalibao.backend','Cms Page ID'),
            'index' => Yii::t('kalibao.backend','Index'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPage()
    {
        return $this->hasOne(CmsPage::className(), ['id' => 'cms_page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPageContentI18ns()
    {
        return $this->hasMany(CmsPageContentI18n::className(), ['cms_page_content_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPageI18ns()
    {
        return $this->hasMany(CmsPageI18n::className(), ['cms_page_id' => 'cms_page_id']);
    }
}
