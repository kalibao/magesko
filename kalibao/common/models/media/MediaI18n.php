<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\media;

use Yii;
use kalibao\common\models\language\Language;
use kalibao\common\models\media\Media;

/**
 * This is the model class for table "media_i18n".
 *
 * @property integer $media_id
 * @property string $i18n_id
 * @property string $title
 *
 * @property Language $i18n
 * @property Media $media
 *
 * @package kalibao\common\models\media
 * @version 1.0
 */
class MediaI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media_i18n';
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
            [['media_id', 'i18n_id'], 'required', 'on' => ['insert', 'update', 'translate']],
            [['media_id'], 'integer'],
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
            'media_id' => Yii::t('kalibao.backend','label_media_id'),
            'i18n_id' => Yii::t('kalibao.backend','label_i18n_id'),
            'title' => Yii::t('kalibao.backend','label_media_title'),
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
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
}
