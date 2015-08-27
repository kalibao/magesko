<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsImage;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsImageGroup\CmsImageGroup;
use kalibao\common\models\cmsImageGroup\CmsImageGroupI18n;

/**
 * This is the model class for table "cms_image".
 *
 * @property integer $id
 * @property string $file_path
 * @property integer $cms_image_group_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsImageGroup $cmsImageGroup
 * @property CmsImageI18n[] $cmsImageI18ns
 * @property CmsImageGroupI18n[] $cmsImageGroupI18ns
 *
 * @package kalibao\backend\modules\cms\models\cmsImage
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsImage extends \yii\db\ActiveRecord
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
        return 'cms_image';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'file_path', 'cms_image_group_id'
            ],
            'update' => [
                'file_path', 'cms_image_group_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['file_path', 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'skipOnEmpty' => false, 'when' => function ($model) { return $model->file_path == ''; }, 'whenClient' => "function (attribute, value) { return $(attribute.input).attr('value') === '' || $(attribute.input).attr('value') === undefined; }"],
            ['file_path', 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'skipOnEmpty' => true, 'when' => function ($model) { return $model->file_path !== ''; }, 'whenClient' => "function (attribute, value) { return $(attribute.input).attr('value') != '' && $(attribute.input).attr('value') !== undefined; }"],
            [['cms_image_group_id'], 'required'],
            [['cms_image_group_id'], 'integer'],
            [['file_path'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'file_path' => Yii::t('kalibao','cms_image:file_path'),
            'cms_image_group_id' => Yii::t('kalibao','cms_image:cms_image_group_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImageGroup()
    {
        return $this->hasOne(CmsImageGroup::className(), ['id' => 'cms_image_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImageI18ns()
    {
        return $this->hasMany(CmsImageI18n::className(), ['cms_image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImageGroupI18ns()
    {
        return $this->hasMany(CmsImageGroupI18n::className(), ['cms_image_group_id' => 'cms_image_group_id']);
    }
}
