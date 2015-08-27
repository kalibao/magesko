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
 * Class CompanyTypeController
 *
 * @package kalibao\backend\modules\third\controllers
 * @version 1.0
 */
class CompanyTypeController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\company\CompanyType',
        'i18n' => 'kalibao\common\models\company\CompanyTypeI18n',
        'filter' => 'kalibao\backend\modules\third\models\companyType\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\third\components\companyType\crud\Edit',
        'list' => 'kalibao\backend\modules\third\components\companyType\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\third\components\companyType\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\third\components\companyType\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\third\components\companyType\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\third\components\companyType\crud\Translate',
        'setting' => 'kalibao\backend\modules\third\components\companyType\crud\Setting',
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