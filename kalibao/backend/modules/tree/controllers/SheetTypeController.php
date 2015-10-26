<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class SheetTypeController
 *
 * @package kalibao\backend\modules\tree\controllers
 * @version 1.0
 */
class SheetTypeController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\sheetType\SheetType',
        'i18n' => 'kalibao\common\models\sheetType\SheetTypeI18n',
        'filter' => 'kalibao\backend\modules\tree\models\sheetType\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\tree\components\sheetType\crud\Edit',
        'list' => 'kalibao\backend\modules\tree\components\sheetType\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\tree\components\sheetType\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\tree\components\sheetType\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\tree\components\sheetType\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\tree\components\sheetType\crud\Translate',
        'setting' => 'kalibao\backend\modules\tree\components\sheetType\crud\Setting',
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
            case 'tables':
                $tableNames = [];
                foreach (Yii::$app->db->schema->getTableNames() as $table) {
                    if ($search != '' && strpos($table, $search) === false) continue;
                    $tableNames[] = ['id' => $table, 'text' => $table];
                }
                return $tableNames;
            default:
                return [];
                break;
        }
    }
}