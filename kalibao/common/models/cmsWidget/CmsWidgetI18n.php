<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\cmsWidget;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "cms_widget_i18n".
 *
 * @property integer $cms_widget_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property CmsWidget $cmsWidget
 * @property Language $i18n
 *
 * @package kalibao\common\models\cmsWidget
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsWidgetI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_widget_i18n';
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
            [['cms_widget_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['cms_widget_id'], 'integer'],
            [['title'], 'required'],
            [['i18n_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cms_widget_id' => Yii::t('kalibao','model:id'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsWidget()
    {
        return $this->hasOne(CmsWidget::className(), ['id' => 'cms_widget_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }
}
