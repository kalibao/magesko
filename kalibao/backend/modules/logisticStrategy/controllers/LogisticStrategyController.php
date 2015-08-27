<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\logisticStrategy\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class LogisticStrategyController
 *
 * @package kalibao\backend\modules\logisticStrategy\controllers
 * @version 1.0
 */
class LogisticStrategyController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\logisticStrategy\LogisticStrategy',
        'i18n' => 'kalibao\common\models\logisticStrategy\LogisticStrategyI18n',
        'filter' => 'kalibao\backend\modules\logisticStrategy\models\logisticStrategy\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud\Edit',
        'list' => 'kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud\Translate',
        'setting' => 'kalibao\backend\modules\logisticStrategy\components\logisticStrategy\crud\Setting',
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
                case 'checkbox-drop-down-list':
                    $this->dropDownLists['checkbox-drop-down-list'] = Html::checkboxInputFilterDropDownList();
                    break;
                case 'supplier.name':
                    $this->dropDownLists['supplier.name'] = Html::findDropDownListData(
                        'kalibao\common\models\supplier\Supplier',
                        ['id', 'name'],
                        []
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
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {
            default:
                return [];
                break;
        }
    }
}