<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\message\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class MessageGroupController
 *
 * @package kalibao\backend\modules\message\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MessageGroupController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\messageGroup\MessageGroup',
        'i18n' => 'kalibao\common\models\messageGroup\MessageGroupI18n',
        'filter' => 'kalibao\backend\modules\message\models\messageGroup\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\message\components\messageGroup\crud\Edit',
        'list' => 'kalibao\backend\modules\message\components\messageGroup\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\message\components\messageGroup\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\message\components\messageGroup\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\message\components\messageGroup\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\message\components\messageGroup\crud\Translate',
        'setting' => 'kalibao\backend\modules\message\components\messageGroup\crud\Setting',
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

        // refresh messages
        $refreshMessages = function () {
            Yii::$app->i18n->getMessageSource('kalibao')->refreshMessages();
        };
        $this->on(self::EVENT_DELETE, $refreshMessages);
        $this->on(self::EVENT_SAVE_EDIT, $refreshMessages);
        $this->on(self::EVENT_SAVE_TRANSLATE, $refreshMessages);
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