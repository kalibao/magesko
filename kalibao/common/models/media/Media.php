<?php
/**
* @copyright Copyright (c) 2015 Kalibao
* @license https://github.com/kalibao/magesko/blob/master/LICENSE
*/

namespace kalibao\common\models\media;

use Yii;
use yii\behaviors\TimestampBehavior;
use kalibao\common\models\category\Category;
use kalibao\common\models\mediaType\MediaType;
use kalibao\common\models\media\MediaI18n;
use kalibao\common\models\productMedia\ProductMedia;
use kalibao\common\models\mediaType\MediaTypeI18n;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property string $file
 * @property integer $media_type_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category[] $categories
 * @property MediaType $mediaType
 * @property MediaI18n[] $mediaI18ns
 * @property ProductMedia[] $productMedia
 * @property MediaTypeI18n[] $mediaTypeI18ns
 *
 * @package kalibao\common\models\media
 * @version 1.0
 */
class Media extends \yii\db\ActiveRecord
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
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                'file', 'media_type_id'
            ],
            'update' => [
                'file', 'media_type_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['file', 'file', 'skipOnEmpty' => false, 'when' => function ($model) { return $model->file == ''; }, 'whenClient' => "function (attribute, value) { return $(attribute.input).attr('value') === '' || $(attribute.input).attr('value') === undefined; }"],
            ['file', 'file', 'skipOnEmpty' => true, 'when' => function ($model) { return $model->file !== ''; }, 'whenClient' => "function (attribute, value) { return $(attribute.input).attr('value') != '' && $(attribute.input).attr('value') !== undefined; }"],
            [['media_type_id'], 'required'],
            [['media_type_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kalibao.backend','label_media_id'),
            'file' => Yii::t('kalibao.backend','label_media_file'),
            'media_type_id' => Yii::t('kalibao.backend','label_media_type_id'),
            'created_at' => Yii::t('kalibao','model:created_at'),
            'updated_at' => Yii::t('kalibao','model:updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaType()
    {
        return $this->hasOne(MediaType::className(), ['id' => 'media_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaI18ns()
    {
        return $this->hasMany(MediaI18n::className(), ['media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery | false
     */
    public function getMediaI18n()
    {
        $i18ns = $this->mediaI18ns;
        foreach ($i18ns as $i18n) {
            if ($i18n->i18n_id == Yii::$app->language) return $i18n;
        }
        if (array_key_exists(0, $i18ns)) return $i18ns[0];
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductMedia()
    {
        return $this->hasMany(ProductMedia::className(), ['media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaTypeI18ns()
    {
        return $this->hasMany(MediaTypeI18n::className(), ['media_type_id' => 'media_type_id']);
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

    /**
     * function to display a media using HTML5 features. (based on mime type)
     * outputs a video player, an audio player, a picture or a link
     * @return string The HTML code to display media.
     * @throws \yii\base\InvalidConfigException
     */
    public function getHtml()
    {
        $webpath  = Yii::$app->cdnManager->getBaseUrl() . '/common/data/' . $this->file;
        $filepath = Yii::getAlias('@kalibao/data/') . $this->file;
        $downloadUrl = Url::to(['/media/media/download'] + ['file' => $this->id]);
        $mimeType = FileHelper::getMimeType($filepath);
        $title = (($this->mediaI18n)?$this->mediaI18n->title:$this->file);
        if (explode('/', $mimeType)[0] == 'video') {
            return <<<VIDEO
<div class="media">
        <div class="media-left media-middle col-xs-5">
            <video style="width:100%" class="thumbnail media-object" controls preload="auto" src="$webpath">Not supported</video>
        </div>
        <div class="media-body">
            <h4 class="media-heading">$title</h4>
            <p>
                <b>Taille :</b> {$this->human_filesize(filesize($filepath))}<br>
                <a href="$webpath" target="_blank">Apperçu</a> &bull; <a href="$downloadUrl">Télécharger</a> &bull; <i class="fa fa-trash delete-product-media" data-id=$this->id></i>
                </p>
        </div>
</div>
<hr/>
VIDEO;
        } elseif (explode('/', $mimeType)[0] == 'image') {
            return <<<IMG
<div class="media">
        <div class="media-left media-middle col-xs-3">
            <img style="width:100%" class="thumbnail media-object" src="$webpath" />
        </div>
        <div class="media-body">
            <h4 class="media-heading">$title</h4>
            <p>
                <b>Taille :</b> {$this->human_filesize(filesize($filepath))}<br>
                <a href="$webpath" target="_blank">Apperçu</a> &bull; <a href="$downloadUrl">Télécharger</a> &bull; <i class="fa fa-trash delete-product-media" data-id=$this->id></i>
                </p>
        </div>
</div>
<hr/>
IMG;
        } elseif (explode('/', $mimeType)[0] == 'audio') {
        return <<<AUDIO
<div class="media">
        <div class="media-left media-middle col-xs-5">
            <audio style="width:100%" class="media-object" controls preload="auto" src="$webpath">Not supported</audio>
        </div>
        <div class="media-body">
            <h4 class="media-heading">$title</h4>
            <p>
                <b>Taille :</b> {$this->human_filesize(filesize($filepath))}<br>
                <a href="$downloadUrl">Télécharger</a> &bull; <i class="fa fa-trash delete-product-media" data-id=$this->id></i>
            </p>
        </div>
</div>
<hr/>
AUDIO;
         } else {
            return <<<LINK
<div class="media">
        <div class="media-left media-middle col-xs-2">
            <i class="fa fa-3x fa-file-text"></i>
        </div>
        <div class="media-body">
            <h4 class="media-heading">$title</h4>
            <p>
                <b>Taille :</b> {$this->human_filesize(filesize($filepath))}<br>
                <a href="$downloadUrl">Télécharger</a> &bull; <i class="fa fa-trash delete-product-media" data-id=$this->id></i>
            </p>
        </div>
</div>
<hr/>
LINK;
        }
    }

    /**
     * function to convert a size in bytes into a human readable size
     * output in byte, kilo, mega, giga, tera, peta
     * @param int $bytes number of bytes to convert into a human readable format
     * @param int $decimals number of decimals for the result
     * @return string the size in a human readable format
     */
    private function human_filesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
    }
}
