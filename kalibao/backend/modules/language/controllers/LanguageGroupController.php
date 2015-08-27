<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\language\controllers;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class LanguageGroupController
 *
 * @package kalibao\backend\modules\language\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class LanguageGroupController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\languageGroup\LanguageGroup',
        'i18n' => 'kalibao\common\models\languageGroup\LanguageGroupI18n',
        'filter' => 'kalibao\backend\modules\language\models\languageGroup\crud\ModelFilter'
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\language\components\languageGroup\crud\Edit',
        'list' => 'kalibao\backend\modules\language\components\languageGroup\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\language\components\languageGroup\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\language\components\languageGroup\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\language\components\languageGroup\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\language\components\languageGroup\crud\Translate',
        'setting' => 'kalibao\backend\modules\language\components\languageGroup\crud\Setting',
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

        // refresh languages
        $refreshLanguages = function ($event) {
            Yii::$app->appLanguage->refreshLanguages();
        };
        $this->on(self::EVENT_DELETE, $refreshLanguages);
        $this->on(self::EVENT_SAVE_EDIT, $refreshLanguages);
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