<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsSimpleMenu;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsSimpleMenuGroup\CmsSimpleMenuGroup;
use kalibao\common\models\cmsSimpleMenuGroup\CmsSimpleMenuGroupI18n;
/**
 * This is the model class for table "cms_simple_menu".
 *
 * @property integer $id
 * @property integer $position
 * @property integer $cms_simple_menu_group_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsSimpleMenuGroup $cmsSimpleMenuGroup
 * @property CmsSimpleMenuI18n[] $cmsSimpleMenuI18ns
 * @property CmsSimpleMenuGroupI18n[] $cmsSimpleMenuGroupI18ns
 *
 * @package kalibao\common\models\cmsSimpleMenu
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsSimpleMenu extends \yii\db\ActiveRecord
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
        return 'cms_simple_menu';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'position', 'cms_simple_menu_group_id'
            ],
            'update' => [
                'position', 'cms_simple_menu_group_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position', 'cms_simple_menu_group_id'], 'required'],
            [['position', 'cms_simple_menu_group_id'], 'integer'],
            [['position'], 'integer', 'min' => 0, 'max' => 1000],
            [['position'], 'unique', 'targetAttribute' => ['position', 'cms_simple_menu_group_id'], 'message' => Yii::t('kalibao', 'The combination of position and CmsSimpleMenuGroupId has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'position' => Yii::t('kalibao','cms_simple_menu:position'),
            'cms_simple_menu_group_id' => Yii::t('kalibao','cms_simple_menu:cms_simple_menu_group_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsSimpleMenuGroup()
    {
        return $this->hasOne(CmsSimpleMenuGroup::className(), ['id' => 'cms_simple_menu_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsSimpleMenuI18ns()
    {
        return $this->hasMany(CmsSimpleMenuI18n::className(), ['cms_simple_menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsSimpleMenuGroupI18ns()
    {
        return $this->hasMany(CmsSimpleMenuGroupI18n::className(), ['cms_simple_menu_group_id' => 'cms_simple_menu_group_id']);
    }
}
