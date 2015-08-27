<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsPageContent;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "cms_page_content_i18n".
 *
 * @property integer $cms_page_content_id
 * @property string $i18n_id
 * @property string $content
 *
 * @property CmsPageContent $cmsPageContent
 * @property Language $i18n
 *
 * @package kalibao\backend\modules\cms\models\cmsPageContent
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsPageContentI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page_content_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'content'
            ],
            'update' => [
                'content'
            ],
            'translate' => [
                'content'
            ],
            'beforeInsert' => [
                'content'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_page_content_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_page_content_id'], 'integer'],
            //[['content'], 'required', 'message' => 'Le bloc ne peut pas être vide.'],
            [['content'], 'string'],
            [['i18n_id'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cms_page_content_id' => Yii::t('kalibao.backend','Cms Page Content ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'content' => Yii::t('kalibao.backend','Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPageContent()
    {
        return $this->hasOne(CmsPageContent::className(), ['id' => 'cms_page_content_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
