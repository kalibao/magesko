<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsNews;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "cms_news_i18n".
 *
 * @property integer $cms_news_id
 * @property string $i18n_id
 * @property string $title
 * @property string $content
 *
 * @property Language $i18n
 * @property CmsNews $cmsNews
 *
 * @package kalibao\common\models\cmsNews
 * @version 1.0
 */
class CmsNewsI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_news_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'title', 'content'
            ],
            'update' => [
                'title', 'content'
            ],
            'translate' => [
                'title', 'content'
            ],
            'beforeInsert' => [
                'title', 'content'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_news_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_news_id'], 'integer'],
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['i18n_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cms_news_id' => Yii::t('kalibao','model:id'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
            'content' => Yii::t('kalibao','cms_news_i18n:content'),
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
    public function getCmsNews()
    {
        return $this->hasOne(CmsNews::className(), ['id' => 'cms_news_id']);
    }
}
