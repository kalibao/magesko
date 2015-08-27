<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsLayout;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "cms_layout_i18n".
 *
 * @property integer $cms_layout_id
 * @property string $i18n_id
 * @property string $name
 *
 * @property Language $i18n
 * @property CmsLayout $cmsLayout
 *
 * @package kalibao\common\models\cmsLayout
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsLayoutI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_layout_i18n';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'name'
            ],
            'update' => [
                'name'
            ],
            'translate' => [
                'name'
            ],
            'beforeInsert' => [
                'name'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_layout_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_layout_id'], 'integer'],
            [['name'], 'required'],
            [['i18n_id'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cms_layout_id' => Yii::t('kalibao.backend','Cms Layout ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'name' => Yii::t('kalibao','model:title'),
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
    public function getCmsLayout()
    {
        return $this->hasOne(CmsLayout::className(), ['id' => 'cms_layout_id']);
    }
}
