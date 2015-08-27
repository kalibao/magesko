<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsImageGroup;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "cms_image_group_i18n".
 *
 * @property integer $cms_image_group_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property CmsImageGroup $cmsImageGroup
 *
 * @package kalibao\backend\modules\cms\models\cmsImageGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsImageGroupI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_image_group_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'title'
            ],
            'update' => [
                'title'
            ],
            'translate' => [
                'title'
            ],
            'beforeInsert' => [
                'title'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_image_group_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_image_group_id'], 'integer'],
            [['title'], 'required'],
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
            'cms_image_group_id' => Yii::t('kalibao.backend','Cms Image Group ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
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
    public function getCmsImageGroup()
    {
        return $this->hasOne(CmsImageGroup::className(), ['id' => 'cms_image_group_id']);
    }
}
