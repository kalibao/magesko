<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class CmsWidgetGroupController
 *
 * @package kalibao\backend\modules\cms\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsWidgetGroupController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\cmsWidgetGroup\CmsWidgetGroup',
        'i18n' => 'kalibao\common\models\cmsWidgetGroup\CmsWidgetGroupI18n',
        'filter' => 'kalibao\backend\modules\cms\models\cmsWidgetGroup\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\cms\components\cmsWidgetGroup\crud\Edit',
        'list' => 'kalibao\backend\modules\cms\components\cmsWidgetGroup\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\cms\components\cmsWidgetGroup\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\cms\components\cmsWidgetGroup\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\cms\components\cmsWidgetGroup\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\cms\components\cmsWidgetGroup\crud\Translate',
        'setting' => 'kalibao\backend\modules\cms\components\cmsWidgetGroup\crud\Setting',
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
            default:
                return [];
                break;
        }
    }
}