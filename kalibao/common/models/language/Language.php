<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\models\language;

use Yii;
use kalibao\common\models\rbacPermission\RbacPermission;

/**
 * This is the model class for table "language".
 *
 * @property string $id
 *
 * @property LanguageI18n[] $languageI18ns
 *
 * @package kalibao\common\models\language
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => ['id'],
            'update' => ['id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao','model:id'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageI18ns()
    {
        return $this->hasMany(LanguageI18n::className(), ['language_id' => 'id']);
    }
}
