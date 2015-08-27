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
 * Class CompanyController
 *
 * @package kalibao\backend\modules\third\controllers
 * @version 1.0
 */
class CompanyController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\company\Company',
        'filter' => 'kalibao\backend\modules\third\models\company\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\third\components\company\crud\Edit',
        'list' => 'kalibao\backend\modules\third\components\company\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\third\components\company\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\third\components\company\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\third\components\company\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\third\components\company\crud\Translate',
        'setting' => 'kalibao\backend\modules\third\components\company\crud\Setting',
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
            case 'third.id':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\third\Third',
                    ['id', 'id'],
                    [['LIKE', 'id', $search]],
                    10
                );
                break;
            case 'company_type_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\companyType\CompanyTypeI18n',
                    ['company_type_id', 'title'],
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