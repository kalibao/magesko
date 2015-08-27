<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\variable\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class VariableGroupController
 *
 * @package kalibao\backend\modules\variable\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class VariableGroupController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\variableGroup\VariableGroup',
        'i18n' => 'kalibao\common\models\variableGroup\VariableGroupI18n',
        'filter' => 'kalibao\backend\modules\variable\models\variableGroup\crud\ModelFilter'
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\variable\components\variableGroup\crud\Edit',
        'list' => 'kalibao\backend\modules\variable\components\variableGroup\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\variable\components\variableGroup\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\variable\components\variableGroup\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\variable\components\variableGroup\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\variable\components\variableGroup\crud\Translate',
        'setting' => 'kalibao\backend\modules\variable\components\variableGroup\crud\Setting',
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

        // refresh variables
        $refreshVariables = function ($event) {
            Yii::$app->variable->refreshVariables();
        };
        $this->on(self::EVENT_DELETE, $refreshVariables);
        $this->on(self::EVENT_SAVE_EDIT, $refreshVariables);
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