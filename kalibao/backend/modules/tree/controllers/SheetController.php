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
 * Class SheetController
 *
 * @package kalibao\backend\modules\tree\controllers
 * @version 1.0
 */
class SheetController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\sheet\Sheet',
        'filter' => 'kalibao\backend\modules\tree\models\sheet\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\tree\components\sheet\crud\Edit',
        'list' => 'kalibao\backend\modules\tree\components\sheet\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\tree\components\sheet\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\tree\components\sheet\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\tree\components\sheet\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\tree\components\sheet\crud\Translate',
        'setting' => 'kalibao\backend\modules\tree\components\sheet\crud\Setting',
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
            case 'sheet_type_i18n.label':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\sheetType\SheetTypeI18n',
                    ['sheet_type_id', 'label'],
                    [['LIKE', 'label', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'branch_i18n.label':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\branch\BranchI18n',
                    ['branch_id', 'label'],
                    [['LIKE', 'label', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }
}