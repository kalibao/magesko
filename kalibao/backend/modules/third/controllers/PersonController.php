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
 * Class PersonController
 *
 * @package kalibao\backend\modules\third\controllers
 * @version 1.0
 */
class PersonController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\person\Person',
        'filter' => 'kalibao\backend\modules\third\models\person\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\third\components\person\crud\Edit',
        'list' => 'kalibao\backend\modules\third\components\person\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\third\components\person\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\third\components\person\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\third\components\person\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\third\components\person\crud\Translate',
        'setting' => 'kalibao\backend\modules\third\components\person\crud\Setting',
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
            case 'language_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\language\LanguageI18n',
                    ['language_id', 'title'],
                    [['LIKE', 'title', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'user.username':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\user\User',
                    ['id', 'username'],
                    [['LIKE', 'username', $search]],
                    10
                );
                break;
            case 'person_gender_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\person\PersonGenderI18n',
                    ['gender_id', 'title'],
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