<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsWidget;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsWidgetGroup\CmsWidgetGroup;
use kalibao\common\models\cmsWidgetGroup\CmsWidgetGroupI18n;

/**
 * This is the model class for table "cms_widget".
 *
 * @property integer $id
 * @property string $path
 * @property string $arg
 * @property integer $cms_widget_group_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsWidgetGroup $cmsWidgetGroup
 * @property CmsWidgetI18n[] $cmsWidgetI18ns
 * @property CmsWidgetGroupI18n[] $cmsWidgetGroupI18ns
 *
 * @package kalibao\common\models\cmsWidget
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsWidget extends \yii\db\ActiveRecord
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
        return 'cms_widget';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'path', 'arg', 'cms_widget_group_id'
            ],
            'update' => [
                'path', 'arg', 'cms_widget_group_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'arg', 'cms_widget_group_id'], 'required'],
            [['arg'], 'string'],
            [['cms_widget_group_id'], 'integer'],
            [['path'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'path' => Yii::t('kalibao','cms_widget:path'),
            'arg' => Yii::t('kalibao','cms_widget:arg'),
            'cms_widget_group_id' => Yii::t('kalibao','cms_widget:cms_widget_group_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsWidgetGroup()
    {
        return $this->hasOne(CmsWidgetGroup::className(), ['id' => 'cms_widget_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsWidgetI18ns()
    {
        return $this->hasMany(CmsWidgetI18n::className(), ['cms_widget_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsWidgetGroupI18ns()
    {
        return $this->hasMany(CmsWidgetGroupI18n::className(), ['cms_widget_group_id' => 'cms_widget_group_id']);
    }
}
