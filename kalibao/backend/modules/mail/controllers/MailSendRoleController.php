<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class MailSendRoleController
 *
 * @package kalibao\backend\modules\mail\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailSendRoleController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\mailSendRole\MailSendRole',
        'i18n' => 'kalibao\common\models\mailSendRole\MailSendRoleI18n',
        'filter' => 'kalibao\backend\modules\mail\models\mailSendRole\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\mail\components\mailSendRole\crud\Edit',
        'list' => 'kalibao\backend\modules\mail\components\mailSendRole\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\mail\components\mailSendRole\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\mail\components\mailSendRole\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\mail\components\mailSendRole\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\mail\components\mailSendRole\crud\Translate',
        'setting' => 'kalibao\backend\modules\mail\components\mailSendRole\crud\Setting',
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