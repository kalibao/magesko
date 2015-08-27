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
use yii\web\Response;

/**
 * Class MailTemplateController
 *
 * @package kalibao\backend\modules\mail\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailTemplateController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\mailTemplate\MailTemplate',
        'i18n' => 'kalibao\common\models\mailTemplate\MailTemplateI18n',
        'filter' => 'kalibao\backend\modules\mail\models\mailTemplate\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\mail\components\mailTemplate\crud\Edit',
        'list' => 'kalibao\backend\modules\mail\components\mailTemplate\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\mail\components\mailTemplate\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\mail\components\mailTemplate\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\mail\components\mailTemplate\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\mail\components\mailTemplate\crud\Translate',
        'setting' => 'kalibao\backend\modules\mail\components\mailTemplate\crud\Setting',
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
    public function actionCreate()
    {
        // request component
        $request = Yii::$app->request;
        // load models
        $models = $this->loadEditModels();

        // save models
        $saved = false;
        if ($request->isPost) {
            $saved = $this->saveEditModels($models, $request->post());
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
            'models' => $models,
            'language' => Yii::$app->language,
            'addAgain' => $request->get('add-again', true),
            'saved' => $saved,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            }
        ]);

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/edit/_contentBlock', ['crudEdit' => $crudEdit]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/edit/edit', ['crudEdit' => $crudEdit]);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate()
    {
        // request component
        $request = Yii::$app->request;

        // get primary key used to find model
        $modelClass = $this->crudModelsClass['main'];
        $primaryKey = $modelClass::primaryKey()[0];
        if (($value = $request->get($primaryKey, false)) === false || $value === '') {
            throw new InvalidParamException();
        }

        // load models
        $models = $this->loadEditModels([$primaryKey => $value]);

        // save models
        $saved = false;
        if ($request->isPost) {;
            $saved = $this->saveEditModels($models, $request->post());
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
            'models' => $models,
            'language' => Yii::$app->language,
            'saved' => $saved,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            }
        ]);

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/edit/_contentBlock', ['crudEdit' => $crudEdit]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/edit/edit', ['crudEdit' => $crudEdit]);
        }
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
            case 'mail_template_group_i18n.title':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\mailTemplateGroup\MailTemplateGroupI18n',
                    ['mail_template_group_id', 'title'],
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