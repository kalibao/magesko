<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\third\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class AddressController
 *
 * @package kalibao\backend\modules\third\controllers
 * @version 1.0
 */
class AddressController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\address\Address',
        'filter' => 'kalibao\backend\modules\third\models\address\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\third\components\address\crud\Edit',
        'list' => 'kalibao\backend\modules\third\components\address\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\third\components\address\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\third\components\address\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\third\components\address\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\third\components\address\crud\Translate',
        'setting' => 'kalibao\backend\modules\third\components\address\crud\Setting',
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
            case 'third.id':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\third\Third',
                    ['id', 'id'],
                    [['LIKE', 'id', $search]],
                    10
                );
                break;
            case 'address_type_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\address\AddressTypeI18n',
                    ['address_type_id', 'title'],
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