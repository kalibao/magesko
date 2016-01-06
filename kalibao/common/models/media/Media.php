<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\models\media;

use kalibao\common\models\category\Category;
use kalibao\common\models\media\MediaI18n;
use kalibao\common\models\mediaType\MediaType;
use kalibao\common\models\mediaType\MediaTypeI18n;
use kalibao\common\models\productMedia\ProductMedia;
use Yii;
use yii\behaviors\TimestampBehavior;
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
                'file',
                'media_type_id'
            ],
            'update' => [
                'file',
                'media_type_id'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'file',
                'file',
                'skipOnEmpty' => false,
                'when'        => function ($model) {
                    return $model->file == '';
                },
                'whenClient'  => "function (attribute, value) { return $(attribute.input).attr('value') === '' || $(attribute.input).attr('value') === undefined; }"
            ],
            [
                'file',
                'file',
                'skipOnEmpty' => true,
                'when'        => function ($model) {
                    return $model->file !== '';
                },
                'whenClient'  => "function (attribute, value) { return $(attribute.input).attr('value') != '' && $(attribute.input).attr('value') !== undefined; }"
            ],
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
            'id'            => Yii::t('kalibao.backend', 'label_media_id'),
            'file'          => Yii::t('kalibao.backend', 'label_media_file'),
            'media_type_id' => Yii::t('kalibao.backend', 'label_media_type_id'),
            'created_at'    => Yii::t('kalibao', 'model:created_at'),
            'updated_at'    => Yii::t('kalibao', 'model:updated_at'),
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
            if ($i18n->i18n_id == Yii::$app->language) {
                return $i18n;
            }
        }
        if (array_key_exists(0, $i18ns)) {
            return $i18ns[0];
        }
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
            if ($i18n->i18n_id == Yii::$app->language) {
                return $i18n;
            }
        }
        if (array_key_exists(0, $i18ns)) {
            return $i18ns[0];
        }
        return false;
    }

    /**
     * extract information from media file and calls the appropriate function to render the file using mime type
     * @return string The HTML code to display media.
     * @throws \yii\base\InvalidConfigException
     */
    public function getHtml()
    {
        if (filter_var($this->file, FILTER_VALIDATE_URL) !== false) {
            $headers = $mime = get_headers($this->file, true);

            $paths['file'] = $this->file;
            $paths['download'] = $this->file;
            $paths['web'] = $this->file;

            $mimeType = $headers['Content-Type'];

            $fileInfo['size'] = array_key_exists('Content-Length', $headers) ?
                $this->human_filesize($headers['Content-Length']) : 'inconnu';
            $fileInfo['isExternal'] = true;

            $title = '<i class="fa fa-external-link"></i> ' . (($this->mediaI18n) ? $this->mediaI18n->title : $this->file);
        } else {
            $paths['web'] = Yii::$app->cdnManager->getBaseUrl() . '/common/data/' . $this->file;
            $paths['file'] = Yii::getAlias('@kalibao/data/') . $this->file;
            $paths['download'] = Url::to(['/media/media/download'] + ['file' => $this->id]);

            $mimeType = FileHelper::getMimeType($paths['file']);

            $fileInfo['size'] = $this->human_filesize(filesize($paths['file']));
            $fileInfo['isExternal'] = false;

            $title = (($this->mediaI18n) ? $this->mediaI18n->title : $this->file);
        }

        switch (explode('/', $mimeType)[0]) {
            case 'video':
                return $this->getVideoHtml($paths, $fileInfo, $this->id, $title);
            case 'image':
                if ($fileInfo['isExternal']) {
                    $fileInfo['dimensions'] = 'inconnu';
                } else {
                    $dim = getimagesize($paths['file']);
                    $fileInfo['dimensions'] = $dim[0] . ' × ' . $dim[1] . 'px';
                }
                return $this->getImageHtml($paths, $fileInfo, $this->id, $title);
            case 'audio':
                return $this->getAudioHtml($paths, $fileInfo, $this->id, $title);
            default:
                return $this->getLinkHtml($paths, $fileInfo, $this->id, $title);
        }
    }

    /**
     * returns the html for the video player
     * @param array $paths web, download and file path of the file
     * @param array $fileInfo various information about the file (size, is external)
     * @param int $id id of the media
     * @param string $title title of the media (i18n)
     * @return string the rendered html
     */
    private function getVideoHtml($paths, $fileInfo, $id, $title)
    {
        return "<div class=\"media\">
    <div class=\"media-left media-middle col-xs-5\">
        <video style=\"width:100%\" class=\"thumbnail media-object\" controls preload=\"auto\" src=\"{$paths['web']}\">
            Not supported
        </video>
    </div>
    <div class=\"media-body\">
        <h4 class=\"media-heading\">{$title}</h4>
        <p>
            <b>Taille :</b> {$fileInfo['size']}<br>
            <a href=\"{$paths['web']}\" target=\"_blank\">Aperçu</a> &bull; <a download href=\"{$paths['download']}\">Télécharger</a> &bull;
            <i class=\"fa fa-trash delete-product-media\" data-id={$id}></i>
        </p>
    </div>
</div>
<hr/>";
    }

    /**
     * returns the html for the audio player
     * @param array $paths web, download and file path of the file
     * @param array $fileInfo various information about the file (size, is external)
     * @param int $id id of the media
     * @param string $title title of the media (i18n)
     * @return string the rendered html
     */
    private function getAudioHtml($paths, $fileInfo, $id, $title)
    {
        return "<div class=\"media\">
    <div class=\"media-left media-middle col-xs-5\">
        <audio style=\"width:100%\" class=\"thumbnail media-object\" controls preload=\"auto\" src=\"{$paths['web']}\">
            Not supported
        </audio>
    </div>
    <div class=\"media-body\">
        <h4 class=\"media-heading\">{$title}</h4>
        <p>
            <b>Taille :</b> {$fileInfo['size']}<br>
            <a download href=\"{$paths['download']}\">Télécharger</a> &bull;
            <i class=\"fa fa-trash delete-product-media\" data-id={$id}></i>
        </p>
    </div>
</div>
<hr/>";
    }

    /**
     * returns the html for the image
     * @param array $paths web, download and file path of the file
     * @param array $fileInfo various information about the file (size, is external, dimension)
     * @param int $id id of the media
     * @param string $title title of the media (i18n)
     * @return string the rendered html
     */
    private function getImageHtml($paths, $fileInfo, $id, $title)
    {
        return "<div class=\"media\">
    <div class=\"media-left media-middle col-xs-3\">
        <img style=\"width:100%\" class=\"thumbnail media-object\" src=\"{$paths['web']}\">
    </div>
    <div class=\"media-body\">
        <h4 class=\"media-heading\">{$title}</h4>
        <p>
            <b>Taille :</b> {$fileInfo['size']}<br>
            <b>Dimensions :</b> {$fileInfo['dimensions']}<br>
            <a href=\"{$paths['web']}\" target=\"_blank\">Aperçu</a> &bull; <a download href=\"{$paths['download']}\">Télécharger</a> &bull;
            <i class=\"fa fa-trash delete-product-media\" data-id={$id}></i>
        </p>
    </div>
</div>
<hr/>";
    }

    /**
     * returns the html for unknown file types (renders a link and various information)
     * @param array $paths web, download and file path of the file
     * @param array $fileInfo various information about the file (size, is external)
     * @param int $id id of the media
     * @param string $title title of the media (i18n)
     * @return string the rendered html
     */
    private function getLinkHtml($paths, $fileInfo, $id, $title)
    {
        return "<div class=\"media\">
    <div class=\"media-left media-middle col-xs-3\">
        <i class=\"fa fa-3x fa-file-text\"></i>
    </div>
    <div class=\"media-body\">
        <h4 class=\"media-heading\">{$title}</h4>
        <p>
            <b>Taille :</b> {$fileInfo['size']}<br>
            {$paths['web']}<a download href=\"{$paths['download']}\">Télécharger</a> &bull;
            <i class=\"fa fa-trash delete-product-media\" data-id={$id}></i>
        </p>
    </div>
</div>
<hr/>";
    }

    /**
     * function to convert a size in bytes into a human readable size
     * output in byte, kilo, mega, giga, tera, peta
     * @param int $bytes number of bytes to convert into a human readable format
     * @param int $decimals number of decimals for the result
     * @return string the size in a human readable format
     */
    private function human_filesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
    }
}
