<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\category\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class CategoryController
 *
 * @package kalibao\backend\modules\category\controllers
 * @version 1.0
 */
class CategoryController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\category\Category',
        'i18n' => 'kalibao\common\models\category\CategoryI18n',
        'filter' => 'kalibao\backend\modules\category\models\category\crud\ModelFilter',
        'media' => 'kalibao\common\models\media\Media',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\category\components\category\crud\Edit',
        'list' => 'kalibao\backend\modules\category\components\category\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\category\components\category\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\category\components\category\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\category\components\category\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\category\components\category\crud\Translate',
        'setting' => 'kalibao\backend\modules\category\components\category\crud\Setting',
    ];

    private $dropDownLists = [];

    private $imageDropDowns = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set upload config
        $this->uploadConfig = [
            $this->crudModelsClass['main'] => [
            ],
            'kalibao\common\models\media\Media' => [
                'file' => [
                    'basePath' => Yii::getAlias('@kalibao/data'),
                    'baseUrl' => Yii::$app->cdnManager->getBaseUrl() . '/common/data',
                    'type' => 'file'
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function updateUploadedFileName(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {
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
                case 'category_i18n.title':
                    $this->dropDownLists['category_i18n.title'] = Html::findDropDownListData(
                        'kalibao\common\models\category\CategoryI18n',
                        ['category_id', 'title'],
                        [['i18n_id' => Yii::$app->language]]
                    );
                    break;
                case 'media_i18n.title':
                    $this->dropDownLists['media_i18n.title'] = Html::findDropDownListData(
                        'kalibao\common\models\media\MediaI18n',
                        ['media_id', 'title'],
                        [['i18n_id' => Yii::$app->language]]
                    );
                    break;
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
    protected function getImageDropDown($id)
    {
        if (!isset($this->imageDropDowns[$id])) {
            switch ($id) {
                case 'media.file':
                    $names = Html::findDropDownListData(
                        'kalibao\common\models\media\MediaI18n',
                        ['media_id', 'title'],
                        [['i18n_id' => Yii::$app->language]]
                    );
                    $files = Html::findDropDownListData(
                        'kalibao\common\models\media\Media',
                        ['id', 'file'],
                        []
                    );
                    $data = [];
                    foreach($names as $k => $v) {
                        $data[] = [
                            'text'=> $v,
                            'value'=> $k,
                            'selected'=> false,
                            'imageSrc'=> $this->uploadConfig['kalibao\common\models\media\Media']['file']['baseUrl'] . '/' . $files[$k]
                        ];
                    }
                    var_export($data);
                    $this->imageDropDowns['media.file'] = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT);
                    break;
                default:
                    return [];
                    break;
            }
        }

        return $this->imageDropDowns[$id];
    }

    /**
     * @inheritdoc
     */
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {
            default:
                return [];
                break;
        }
    }
}