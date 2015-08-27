<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsSimpleMenu;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "cms_simple_menu_i18n".
 *
 * @property integer $cms_simple_menu_id
 * @property string $i18n_id
 * @property string $title
 * @property string $url
 *
 * @property CmsSimpleMenu $cmsSimpleMenu
 * @property Language $i18n
 *
 * @package kalibao\common\models\cmsSimpleMenu
 * @version 1.0
 */
class CmsSimpleMenuI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_simple_menu_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'title', 'url'
            ],
            'update' => [
                'title', 'url'
            ],
            'translate' => [
                'title', 'url'
            ],
            'beforeInsert' => [
                'title', 'url'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_simple_menu_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_simple_menu_id'], 'integer'],
            [['title', 'url'], 'required'],
            [['i18n_id'], 'string', 'max' => 16],
            [['title', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cms_simple_menu_id' => Yii::t('kalibao.backend','Cms Simple Menu ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
            'url' => Yii::t('kalibao','cms_simple_menu:url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsSimpleMenu()
    {
        return $this->hasOne(CmsSimpleMenu::className(), ['id' => 'cms_simple_menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
