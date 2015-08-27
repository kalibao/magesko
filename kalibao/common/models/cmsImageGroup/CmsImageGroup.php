<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsImageGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsImage\CmsImage;

/**
 * This is the model class for table "cms_image_group".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsImage[] $cmsImages
 * @property CmsImageGroupI18n[] $cmsImageGroupI18ns
 *
 * @package kalibao\backend\modules\cms\models\cmsImageGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsImageGroup extends \yii\db\ActiveRecord
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
        return 'cms_image_group';
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
    public function getCmsImages()
    {
        return $this->hasMany(CmsImage::className(), ['cms_image_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImageGroupI18ns()
    {
        return $this->hasMany(CmsImageGroupI18n::className(), ['cms_image_group_id' => 'id']);
    }
}
