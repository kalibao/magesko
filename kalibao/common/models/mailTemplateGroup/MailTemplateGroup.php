<?php
/**
* @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\mailTemplateGroup;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\mailTemplate\MailTemplate;

/**
 * This is the model class for table "mail_template_group".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MailTemplate[] $mailTemplates
 * @property MailTemplateGroupI18n[] $mailTemplateGroupI18ns
 *
 * @package kalibao\common\models\mailTemplateGroup
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailTemplateGroup extends \yii\db\ActiveRecord
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
        return 'mail_template_group';
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
    public function getMailTemplates()
    {
        return $this->hasMany(MailTemplate::className(), ['mail_template_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplateGroupI18ns()
    {
        return $this->hasMany(MailTemplateGroupI18n::className(), ['mail_template_group_id' => 'id']);
    }
}
