<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\languageGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\languageGroupLanguage\LanguageGroupLanguage;

/**
 * This is the model class for table "language_group".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property LanguageGroupI18n[] $languageGroupI18ns
 * @property LanguageGroupLanguage[] $languageGroupLanguages
 *
 * @package kalibao\common\models\languageGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class LanguageGroup extends \yii\db\ActiveRecord
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
        return 'language_group';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [],
            'update' => []
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
    public function getLanguageGroupI18ns()
    {
        return $this->hasMany(LanguageGroupI18n::className(), ['language_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageGroupLanguages()
    {
        return $this->hasMany(LanguageGroupLanguage::className(), ['language_group_id' => 'id']);
    }
}
