<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\controllers;

use kalibao\common\components\cms\CmsWidgetService;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;

/**
 * Class CmsWidgetController
 *
 * @package kalibao\backend\modules\cms\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsWidgetController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\cmsWidget\CmsWidget',
        'i18n' => 'kalibao\common\models\cmsWidget\CmsWidgetI18n',
        'filter' => 'kalibao\backend\modules\cms\models\cmsWidget\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\cms\components\cmsWidget\crud\Edit',
        'list' => 'kalibao\backend\modules\cms\components\cmsWidget\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\cms\components\cmsWidget\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\cms\components\cmsWidget\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\cms\components\cmsWidget\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\cms\components\cmsWidget\crud\Translate',
        'setting' => 'kalibao\backend\modules\cms\components\cmsWidget\crud\Setting',
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

        $this->on(self::EVENT_DELETE, function ($event) {
            foreach ($event->extraData['models'] as $model) {
                CmsWidgetService::refreshWidget($model->id);
            }
        });

        $this->on(self::EVENT_SAVE_EDIT, function ($event) {
            CmsWidgetService::refreshWidget($event->extraData['models']['main']->id);
        });
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
            case 'cms_widget_group_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\cmsWidgetGroup\CmsWidgetGroupI18n',
                    ['cms_widget_group_id', 'title'],
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