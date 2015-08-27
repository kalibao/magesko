<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\mediaType;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\media\Media;
use kalibao\common\models\mediaType\MediaTypeI18n;

/**
 * This is the model class for table "media_type".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Media[] $media
 * @property MediaTypeI18n[] $mediaTypeI18ns
 *
 * @package kalibao\common\models\mediaType
 * @version 1.0
 */
class MediaType extends \yii\db\ActiveRecord
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
        return 'media_type';
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
            'id' => Yii::t('kalibao.backend','label_media_type_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['media_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaTypeI18ns()
    {
        return $this->hasMany(MediaTypeI18n::className(), ['media_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getMediaTypeI18n()
    {
        $i18ns = $this->mediaTypeI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }
}
