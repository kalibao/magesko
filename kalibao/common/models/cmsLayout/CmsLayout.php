<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsLayout;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cms_layout".
 *
 * @property integer $id
 * @property integer $max_container
 * @property string $path
 * @property string $view
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsLayoutI18n[] $cmsLayoutI18ns
 * @property CmsPage[] $cmsPages
 *
 * @package kalibao\common\models\cmsLayout
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsLayout extends \yii\db\ActiveRecord
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
        return 'cms_layout';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'max_container', 'path', 'view'
            ],
            'update' => [
                'max_container', 'path', 'view'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max_container'], 'integer', 'min' => 1, 'max' => 10],
            [['path', 'view', 'max_container'], 'required'],
            [['path', 'view'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'max_container' => Yii::t('kalibao','cms_layout:max_container'),
            'path' => Yii::t('kalibao','cms_layout:path'),
            'view' => Yii::t('kalibao','cms_layout:view'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsLayoutI18ns()
    {
        return $this->hasMany(CmsLayoutI18n::className(), ['cms_layout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPages()
    {
        return $this->hasMany(CmsPage::className(), ['cms_layout_id' => 'id']);
    }
}
