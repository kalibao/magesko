<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\affiliationCategory;

use Yii;
use kalibao\common\models\branch\Branch;

/**
 * This is the model class for table "affiliation_category".
 *
 * @property integer $id
 *
 * @property Branch[] $branches
 *
 * @package kalibao\common\models\affiliation
 * @version 1.0
 */
class AffiliationCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'affiliation_category';
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
            'id' => Yii::t('kalibao.backend','ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['affiliation_category_id' => 'id']);
    }
}
