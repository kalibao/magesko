<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\languageGroup;

use Yii;
use kalibao\common\models\language\Language;

/**
 * This is the model class for table "language_group_i18n".
 *
 * @property integer $language_group_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property LanguageGroup $languageGroup
 * @property Language $i18n
 *
 * @package kalibao\common\models\languageGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class LanguageGroupI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language_group_i18n';
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
            'beforeInsert' => [
                'title'
            ],
            'translate' => [
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
            [['language_group_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['language_group_id'], 'integer'],
            [['title'], 'required'],
            [['i18n_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'language_group_id' => Yii::t('kalibao.backend','Language Group ID'),
            'i18n_id' => Yii::t('kalibao.backend','I18n ID'),
            'title' => Yii::t('kalibao','model:title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageGroup()
    {
        return $this->hasOne(LanguageGroup::className(), ['id' => 'language_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->hasOne(Language::className(), ['id' => 'i18n_id']);
    }

    /**
     * Get group language indexed by ID
     * @param string $language Language ID
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getGroupLanguageIndexedById($language)
    {
        return self::find()
            ->select(['language_group_id', 'title'])
            ->where(['i18n_id' => $language])
            ->indexBy('language_group_id')
            ->all();
    }
}
