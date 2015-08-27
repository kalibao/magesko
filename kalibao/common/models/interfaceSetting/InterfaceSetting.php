<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\models\interfaceSetting;

use Yii;
use kalibao\common\models\user\User;

/**
 * This is the model class for table "interface_setting".
 *
 * @property string $interface_id
 * @property string $person_id
 * @property integer $page_size
 *
 * @property User $user
 *
 * @package kalibao\common\models\cmsPageContent
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class InterfaceSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // default value
        $this->page_size = 10;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'interface_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interface_id', 'user_id', 'page_size'], 'required'],
            [['user_id'], 'integer'],
            [['page_size'], 'integer', 'min' => 1, 'max' => 100],
            [['interface_id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'interface_id' => Yii::t('kalibao', 'Interface ID'),
            'user_id' => Yii::t('kalibao', 'User ID'),
            'page_size' => Yii::t('kalibao', 'interface_setting:page_size'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
