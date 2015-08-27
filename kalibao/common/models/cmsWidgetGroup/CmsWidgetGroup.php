<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsWidgetGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsWidget\CmsWidget;

/**
 * This is the model class for table "cms_widget_group".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsWidget[] $cmsWidgets
 * @property CmsWidgetGroupI18n[] $cmsWidgetGroupI18ns
 *
 * @package kalibao\common\models\cmsWidgetGroup
 * @version 1.0
 */
class CmsWidgetGroup extends \yii\db\ActiveRecord
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
        return 'cms_widget_group';
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
    public function getCmsWidgets()
    {
        return $this->hasMany(CmsWidget::className(), ['cms_widget_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsWidgetGroupI18ns()
    {
        return $this->hasMany(CmsWidgetGroupI18n::className(), ['cms_widget_group_id' => 'id']);
    }
}
