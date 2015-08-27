<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\attributeType\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class AttributeTypeController
 *
 * @package kalibao\backend\modules\attributeType\controllers
 * @version 1.0
 */
class AttributeTypeController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\attributeType\AttributeType',
        'i18n' => 'kalibao\common\models\attributeType\AttributeTypeI18n',
        'filter' => 'kalibao\backend\modules\attributeType\models\attributeType\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\attributeType\components\attributeType\crud\Edit',
        'list' => 'kalibao\backend\modules\attributeType\components\attributeType\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\attributeType\components\attributeType\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\attributeType\components\attributeType\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\attributeType\components\attributeType\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\attributeType\components\attributeType\crud\Translate',
        'setting' => 'kalibao\backend\modules\attributeType\components\attributeType\crud\Setting',
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
            case 'attribute_type.value':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\attributeType\AttributeTypeI18n',
                    ['concat(attribute_type_id, "|", value)', 'value'],
                    [['LIKE', 'value', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }
}