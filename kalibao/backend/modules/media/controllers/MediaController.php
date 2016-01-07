<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\media\controllers;

use kalibao\common\components\helpers\Mime;
use kalibao\common\models\media\Media;
use kalibao\common\models\media\MediaI18n;
use kalibao\common\models\product\Product;
use kalibao\common\models\productMedia\ProductMedia;
use Yii;
use yii\base\ErrorException;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class MediaController
 *
 * @package kalibao\backend\modules\media\controllers
 * @version 1.0
 */
class MediaController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\media\Media',
        'i18n' => 'kalibao\common\models\media\MediaI18n',
        'filter' => 'kalibao\backend\modules\media\models\media\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\media\components\media\crud\Edit',
        'list' => 'kalibao\backend\modules\media\components\media\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\media\components\media\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\media\components\media\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\media\components\media\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\media\components\media\crud\Translate',
        'setting' => 'kalibao\backend\modules\media\components\media\crud\Setting',
    ];

    private $dropDownLists = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set upload config
        $this->uploadConfig = [
            $this->crudModelsClass['main'] => [
                'file' => [
                    'basePath' => Yii::getAlias('@kalibao/data'),
                    'baseUrl' => Yii::$app->cdnManager->getBaseUrl() . '/common/data',
                    'type' => 'file'
                ],
            ],
        ];
    }

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['access']['rules'][] = [
            'actions' => ['download'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
        ];
        $b['access']['rules'][] = [
            'actions' => ['from-url'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('update'), 'permission.update:*'],
        ];
        $b['access']['rules'][] = [
            'actions' => ['embed'],
            'allow' => true,
            'roles' => [$this->getActionControllerPermission('update'), 'permission.update:*'],
        ];

        return $b;
    }

    /**
     * @inheritdoc
     */
    protected function updateUploadedFileName(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            case $this->crudModelsClass['main'] . '.file':
                $name = md5(Yii::$app->getSecurity()->generateRandomString() . '.' . uniqid()) . '.' . $model->$attributeName->extension;
                $dataPath = 'products/upload/' . substr($name, 0, 2) . '/';
                $name = $dataPath . $name;
                $path = $this->uploadConfig[$this->crudModelsClass['main']]['file']['basePath'] . '/';

                if (!file_exists($path . $dataPath)) mkdir($path . $dataPath, 0777, true);
                $uploadedFile->name = $name;
                break;
            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function saveUploadedFile(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            case $this->crudModelsClass['main'] . '.file':
                if (!$uploadedFile->saveAs(
                    $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath']
                    . '/' . $uploadedFile->name
                )) {
                    throw new ErrorException('Impossible to save file.');
                }
                break;
            default:
                break;
        }
    }

    /**
     * Download a media file
     */
    public function actionDownload()
    {
        $media = Media::findOne(Yii::$app->request->get('file'));
        $filePath = $this->uploadConfig['kalibao\common\models\media\Media']['file']['basePath'] . '/' . $media->file;
        $fileName = (($media->mediaI18n)?$media->mediaI18n->title:$media->file) . '.' . strtolower(pathinfo($filePath)['extension']);
        return Yii::$app->response->sendFile($filePath, $fileName);
    }


    /**
     * Create action
     * @return string
     * @throws HttpException
     */
    public function actionFromUrl()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            throw new HttpException(405, 'method not allowed');
        }

        $url = $request->post('media_url');
        $import = ($request->post('media_import'))?true:false;
        $title = $request->post('media_title');
        $filename = ($import)? $this->grabImage($url, 'image') : $url;

        $media = new Media(['scenario' => 'insert']);
        $media->file = $filename;
        $media->media_type_id = Yii::$app->variable->get('kalibao.backend', 'media_type_picture');;
        $saveMedia = $media->save();
        if ($saveMedia) {
            $media_i18n = new MediaI18n(['scenario' => 'insert']);
            $media_i18n->media_id = $media->id;
            $media_i18n->i18n_id = Yii::$app->language;
            $media_i18n->title = $title;
            $saveI18n = $media_i18n->save();
            if ($saveI18n) {
                $productMedia = new ProductMedia(['scenario' => 'insert']);
                $productMedia->media_id = $media->id;
                $productMedia->product_id = $request->get('product');
                $saveProductMedia = $productMedia->save();
                TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('product')));
                if ($saveProductMedia) return json_encode(['success' => true]);
            }
        }
        return json_encode(['success' => false]);
    }

    /**
     * Create action
     * @return string
     * @throws HttpException
     */
    public function actionEmbed()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            throw new HttpException(405, 'method not allowed');
        }

        $url = $request->post('media_url');
        $code = $this->getEmbedCode($url);

        if (!$code) return json_encode(['success' => false]);

        $media = new Media(['scenario' => 'insert']);
        $media->file = $code['html'];
        $media->media_type_id = Yii::$app->variable->get('kalibao.backend', 'media_type_embed');;
        $saveMedia = $media->save();
        if ($saveMedia) {
            $media_i18n = new MediaI18n(['scenario' => 'insert']);
            $media_i18n->media_id = $media->id;
            $media_i18n->i18n_id = Yii::$app->language;
            $media_i18n->title = $code['title'];
            $saveI18n = $media_i18n->save();
            if ($saveI18n) {
                $productMedia = new ProductMedia(['scenario' => 'insert']);
                $productMedia->media_id = $media->id;
                $productMedia->product_id = $request->get('product');
                $saveProductMedia = $productMedia->save();
                TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('product')));
                if ($saveProductMedia) return json_encode(['success' => true]);
            }
        }
        return json_encode(['success' => false]);
    }

    /**
     * Create action
     * @return array|string
     * @throws ErrorException
     */
    public function actionCreate()
    {
        // request component
        $request = Yii::$app->request;
        // load models
        $models = $this->loadEditModels();

        // save models
        $saved = false;
        if ($request->isPost) {
            $saved = $this->saveEditModels($models, $request->post());
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
            'models' => $models,
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => $saved,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            }
        ]);

        if ($request->get('product', false)) {
            $productMedia = new ProductMedia(['scenario' => 'insert']);
            $productMedia->media_id = $crudEdit->models['main']->id;
            $productMedia->product_id = $request->get('product');
            if (!$productMedia->save()) {
                var_dump($productMedia->errors);
            }
            TagDependency::invalidate(Yii::$app->commonCache, Product::generateTagStatic($request->get('product')));
        }

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/edit/_contentBlock', ['crudEdit' => $crudEdit]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/edit/edit', ['crudEdit' => $crudEdit]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function removeOldUploadedFile(ActiveRecord $model, $attributeName, $fileName)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            case $this->crudModelsClass['main'] . '.file':
                $oldPath = $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath']
                    . '/' .$fileName;
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
                break;
            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function getDropDownList($id)
    {
        if (!isset($this->dropDownLists[$id])) {
            switch ($id) {
                default:
                    return [];
                    break;
            }
        }

        return $this->dropDownLists[$id];
    }

    /**
     * @inheritdoc
     */
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {
            case 'media_type_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\mediaType\MediaTypeI18n',
                    ['media_type_id', 'title'],
                    [['LIKE', 'title', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * grab a file from given url and save it on the server
     * @param string $url url of the file to grab
     * @param bool|string $type restrict to a specific type based on the first part of the mime type. default to false
     * @return bool|string path of the created file starting from the data folder or false if failed
     */
    private function grabImage($url, $type = false){
        $mime = get_headers($url, true)['Content-Type'];

        if ($type !== false && explode('/', $mime)[0] != $type) {
            return false;
        }

        $ext = Mime::mimeToExtension($mime);
        $name = md5(Yii::$app->getSecurity()->generateRandomString() . '.' . uniqid());
        $dataPath = 'products/grabbed/' . substr($name, 0, 2) . '/';
        $name = $dataPath . $name . $ext;
        $path = $this->uploadConfig[$this->crudModelsClass['main']]['file']['basePath'] . '/';
        $filename = $path . $name;

        if (!file_exists($path . $dataPath)) mkdir($path . $dataPath, 0777, true);
        $fp = fopen ($filename, 'w+');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

        curl_exec($ch);

        curl_close($ch);
        fclose($fp);

        return $name;
    }

    private function getEmbedCode($url)
    {
        $oembedUrl = false;
        if (strpos($url, 'youtu') !== false) $oembedUrl = $this->getOembedUrl($url, 'youtube'); //youtube.com & youtu.be
        if (strpos($url, 'vimeo') !== false) $oembedUrl = $this->getOembedUrl($url, 'vimeo');
        if (strpos($url, 'dailymotion') !== false) $oembedUrl = $this->getOembedUrl($url, 'dailymotion');

        if (!$oembedUrl) return false;

        $curl = curl_init($oembedUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $data = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $data;
    }

    private function getOembedUrl($videoUrl, $host)
    {
        switch ($host) {
            case 'youtube':
                return 'http://www.youtube.com/oembed?format=json&url=' . rawurlencode($videoUrl);
            case 'vimeo':
                return 'https://vimeo.com/api/oembed.json?url=' . rawurlencode($videoUrl);
            case 'dailymotion':
                return 'http://www.dailymotion.com/services/oembed?url=' . rawurlencode($videoUrl);
            default:
                return false;
        }
    }
}