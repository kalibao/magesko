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
 * Class CompanyContactController
 *
 * @package kalibao\backend\modules\third\controllers
 * @version 1.0
 */
class CompanyContactController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\company\CompanyContact',
        'filter' => 'kalibao\backend\modules\third\models\companyContact\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\third\components\companyContact\crud\Edit',
        'list' => 'kalibao\backend\modules\third\components\companyContact\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\third\components\companyContact\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\third\components\companyContact\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\third\components\companyContact\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\third\components\companyContact\crud\Translate',
        'setting' => 'kalibao\backend\modules\third\components\companyContact\crud\Setting',
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
            case 'company.name':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\company\Company',
                    ['third_id', 'name'],
                    [['LIKE', 'name', $search]],
                    10
                );
                break;
            case 'person.last_name':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\person\Person',
                    ['third_id', 'last_name'],
                    [['LIKE', 'last_name', $search]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }
}