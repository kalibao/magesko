<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\controllers;

use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\imagine\Image;

/**
 * Class CmsImageController
 *
 * @package kalibao\backend\modules\cms\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsImageController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\cmsImage\CmsImage',
        'i18n' => 'kalibao\common\models\cmsImage\CmsImageI18n',
        'filter' => 'kalibao\backend\modules\cms\models\cmsImage\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\cms\components\cmsImage\crud\Edit',
        'list' => 'kalibao\backend\modules\cms\components\cmsImage\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\cms\components\cmsImage\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\cms\components\cmsImage\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\cms\components\cmsImage\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\cms\components\cmsImage\crud\Translate',
        'setting' => 'kalibao\backend\modules\cms\components\cmsImage\crud\Setting',
    ];

    private $dropDownLists = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $request = Yii::$app->request;

        if ($request->get('mode', false) === 'explorer') {
            $this->layout = '/simple/simple';
        }

        // set upload config
        $this->uploadConfig = [
            $this->crudModelsClass['main'] => [
                'file_path' => [
                    'basePath' => Yii::getAlias('@kalibao/data/cms-image'),
                    'baseUrl' => Yii::$app->cdnManager->getBaseUrl() . '/common/data/cms-image',
                    'type' => 'image'
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function updateUploadedFileName(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            case $this->crudModelsClass['main'] . '.file_path':
                $dirName = md5(Yii::$app->getSecurity()->generateRandomString() . '.' . uniqid());
                $uploadedFile->name = $dirName . '/' . $model->$attributeName->name;
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
            case $this->crudModelsClass['main'] . '.file_path':
                $dirName = dirname($uploadedFile->name);
                $fileName = basename($uploadedFile->name);

                $dirMin = $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath'] .
                    '/min/' . $dirName;
                $dirMax = $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath'] .
                    '/max/' . $dirName;

                mkdir($dirMin, 0755, true);
                mkdir($dirMax, 0755, true);

                $pathMin = $dirMin . '/' . $fileName;
                $pathMax = $dirMax . '/' . $fileName;
                if (!$uploadedFile->saveAs($pathMax)) {
                    throw new ErrorException('Impossible to save file.');
                } else {
                    Image::thumbnail($pathMax, 400, 400, ManipulatorInterface::THUMBNAIL_INSET)->save($pathMin);
                }
                break;
            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function removeOldUploadedFile(ActiveRecord $model, $attributeName, $fileName)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
            case $this->crudModelsClass['main'] . '.file_path':
                $pathMin = $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath'] .
                    '/min/' . $fileName;
                $pathMax = $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath'] .
                    '/max/' . $fileName;
                if (is_file($pathMin)) {
                    unlink($pathMin);
                }

                rmdir($this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath'] .
                    '/min/' . dirname($fileName));

                if (is_file($pathMax)) {
                    unlink($pathMax);
                }
                rmdir($this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath'] .
                    '/max/' . dirname($fileName));
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
            case 'cms_image_group_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\cmsImageGroup\CmsImageGroupI18n',
                    ['cms_image_group_id', 'title'],
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