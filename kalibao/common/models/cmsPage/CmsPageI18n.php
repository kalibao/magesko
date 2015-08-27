<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsPage;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "cms_page_i18n".
 *
 * @property integer $cms_page_id
 * @property string $i18n_id
 * @property string $title
 * @property string $slug
 * @property string $html_title
 * @property string $html_description
 * @property string $html_keywords
 *
 * @property CmsPage $cmsPage
 * @property Language $i18n
 *
 * @package kalibao\common\models\cmsPage
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsPageI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'title', 'slug', 'html_title', 'html_description', 'html_keywords'
            ],
            'update' => [
                'title', 'slug', 'html_title', 'html_description', 'html_keywords'
            ],
            'translate' => [
                'title', 'slug', 'html_title', 'html_description', 'html_keywords'
            ],
            'beforeInsert' => [
                'title', 'slug', 'html_title', 'html_description', 'html_keywords'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_page_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_page_id'], 'integer'],
            [['title', 'slug'], 'required'],
            [['html_description', 'html_keywords'], 'string'],
            [['i18n_id'], 'string', 'max' => 16],
            [['title', 'slug', 'html_title'], 'string', 'max' => 255],
            [['i18n_id', 'slug'], 'unique', 'targetAttribute' => ['i18n_id', 'slug'], 'message' => Yii::t('kalibao', 'The combination of I18n ID and Slug has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cms_page_id' => Yii::t('kalibao.backend','Cms Page ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
            'slug' => Yii::t('kalibao','cms_page_i18n:slug'),
            'html_title' => Yii::t('kalibao','cms_page_i18n:html_title'),
            'html_description' => Yii::t('kalibao','cms_page_i18n:html_description'),
            'html_keywords' => Yii::t('kalibao','cms_page_i18n:html_keywords'),
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
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
