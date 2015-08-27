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
 * Class LanguageGroupLanguageController
 *
 * @package kalibao\backend\modules\languageGroup\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class LanguageGroupLanguageController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\languageGroupLanguage\LanguageGroupLanguage',
        'filter' => 'kalibao\backend\modules\language\models\languageGroupLanguage\crud\ModelFilter'
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\language\components\languageGroupLanguage\crud\Edit',
        'list' => 'kalibao\backend\modules\language\components\languageGroupLanguage\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\language\components\languageGroupLanguage\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\language\components\languageGroupLanguage\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\language\components\languageGroupLanguage\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\language\components\languageGroupLanguage\crud\Translate',
        'setting' => 'kalibao\backend\modules\language\components\languageGroupLanguage\crud\Setting',
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
                case 'language_group_i18n.title':
                    $this->dropDownLists['language_group_i18n.title'] = Html::findDropDownListData(
                        'kalibao\common\models\languageGroup\LanguageGroupI18n',
                        ['language_group_id', 'title'],
                        [['i18n_id' => Yii::$app->language]]
                    );
                    break;
                case 'language_i18n.title':
                    $this->dropDownLists['language_i18n.title'] = Html::findDropDownListData(
                        'kalibao\common\models\language\LanguageI18n',
                        ['language_id', 'title'],
                        [['i18n_id' => Yii::$app->language]]
                    );
                    break;
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
            default:
                return [];
                break;
        }
    }
}