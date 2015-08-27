<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsImage;

use Yii;

/**
 * This is the model class for table "cms_image_i18n".
 *
 * @property integer $cms_image_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property CmsImage $cmsImage
 * @property Language $i18n
 *
 * @package kalibao\backend\modules\cms\models\cmsImage
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsImageI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_image_i18n';
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
            [['cms_image_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_image_id'], 'integer'],
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
            'cms_image_id' => Yii::t('kalibao.backend','cms_image_i18n:cms_image_id'),
            'i18n_id' => Yii::t('kalibao','model:i18n_id'),
            'title' => Yii::t('kalibao','model:title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImage()
    {
        return $this->hasOne(CmsImage::className(), ['id' => 'cms_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
