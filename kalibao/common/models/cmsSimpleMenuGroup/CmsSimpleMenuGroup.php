<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsSimpleMenuGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\cmsSimpleMenu\CmsSimpleMenu;

/**
 * This is the model class for table "cms_simple_menu_group".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsSimpleMenu[] $cmsSimpleMenus
 * @property CmsSimpleMenuGroupI18n[] $cmsSimpleMenuGroupI18ns
 *
 * @package kalibao\common\models\cmsSimpleMenuGroup
 * @version 1.0
 */
class CmsSimpleMenuGroup extends \yii\db\ActiveRecord
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
        return 'cms_simple_menu_group';
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
    public function getCmsSimpleMenus()
    {
        return $this->hasMany(CmsSimpleMenu::className(), ['cms_simple_menu_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsSimpleMenuGroupI18ns()
    {
        return $this->hasMany(CmsSimpleMenuGroupI18n::className(), ['cms_simple_menu_group_id' => 'id']);
    }
}
