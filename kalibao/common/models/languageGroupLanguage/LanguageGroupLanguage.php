<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\languageGroupLanguage;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\language\LanguageI18n;
use kalibao\common\models\languageGroup\LanguageGroup;
use kalibao\common\models\languageGroup\LanguageGroupI18n;

/**
 * This is the model class for table "language_group_language".
 *
 * @property integer $id
 * @property string $language_group_id
 * @property string $language_id
 * @property integer $activated
 *
 * @property Language $language
 * @property LanguageGroup $languageGroup
 * @property LanguageI18n[] $languageI18ns
 * @property LanguageGroupI18n[] $languageGroupI18ns
 *
 * @package kalibao\common\models\languageGroupLanguage
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class LanguageGroupLanguage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language_group_language';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['language_group_id', 'language_id', 'activated'],
            'update' => ['language_group_id', 'language_id', 'activated'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_group_id', 'language_id', 'activated'], 'required'],
            [['language_group_id'], 'integer'],
            [['activated'], 'in', 'range' => [0, 1]],
            [['language_id'], 'string', 'max' => 16],
            [['language_group_id'], 'unique', 'targetAttribute' => ['language_group_id', 'language_id'], 'message' => Yii::t('kalibao', 'The combination of Language Group ID and Language ID has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
            'language_group_id' => Yii::t('kalibao','language_group_language:language_group_id'),
            'language_id' => Yii::t('kalibao','language_group_language:language_id'),
            'activated' => Yii::t('kalibao','model:activated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
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
    public function getLanguageI18ns()
    {
        return $this->hasMany(LanguageI18n::className(), ['language_id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageGroupI18ns()
    {
        return $this->hasMany(LanguageGroupI18n::className(), ['language_group_id' => 'language_group_id']);
    }

    /**
     * Get languages of language group
     * @param integer $languageGroupId Language group ID
     * @param string $language Language
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getLanguageGroupLanguages($languageGroupId, $language)
    {
        return self::find()
            ->innerJoinWith([
                'languageI18ns' => function ($query) use ($language) {
                    $query->onCondition(['language_i18n.i18n_id' => $language]);
                }
            ])
            ->where(['activated' => 1, 'language_group_id' => $languageGroupId])
            ->all();
    }
}
