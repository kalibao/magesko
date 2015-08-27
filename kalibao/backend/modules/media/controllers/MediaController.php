<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\media\controllers;

use kalibao\common\models\media\Media;
use kalibao\common\models\product\Product;
use kalibao\common\models\productMedia\ProductMedia;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\helpers\FileHelper;
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
                $uploadedFile->name = md5(Yii::$app->getSecurity()->generateRandomString() . '.' . uniqid())
                    . '.' . $model->$attributeName->extension;
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
            var_dump($crudEdit->models);
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
}