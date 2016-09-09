<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tax\controllers;

use kalibao\common\models\taxCountry\TaxCountry;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\web\Response;

/**
 * Class TaxController
 *
 * @package kalibao\backend\modules\tax\controllers
 * @version 1.0
 */
class TaxController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\tax\Tax',
        'i18n' => 'kalibao\common\models\tax\TaxI18n',
        'filter' => 'kalibao\backend\modules\tax\models\tax\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\tax\components\tax\crud\Edit',
        'list' => 'kalibao\backend\modules\tax\components\tax\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\tax\components\tax\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\tax\components\tax\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\tax\components\tax\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\tax\components\tax\crud\Translate',
        'setting' => 'kalibao\backend\modules\tax\components\tax\crud\Setting',
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

    /**
     * @inheritdoc
     */
    public function actionUpdate()
    {
        // request component
        $request = Yii::$app->request;

        // get primary key used to find model
        $modelClass = $this->crudModelsClass['main'];
        $primaryKey = $modelClass::primaryKey();
        $conditions = [];
        foreach ($primaryKey as $primaryKeyElm) {
            if (($value = $request->get($primaryKeyElm, false)) === false || $value === '') {
                throw new InvalidParamException();
            } else {
                $conditions[$primaryKeyElm] = $value;
            }
        }

        // load models
        $models = $this->loadEditModels($conditions);

        // save models
        $saved = false;
        if ($request->isPost) {
            $saved = $this->saveEditModels($models, $request->post());
            if ($saved) $saved &= $this->saveTaxCountry($request->post('country'), $models['main']->id);
        }

        // create a component to display data
        $crudEdit = new $this->crudComponentsClass['edit']([
        'models'       => $models,
        'language'     => Yii::$app->language,
        'saved'        => $saved,
        'uploadConfig' => $this->uploadConfig,
        'dropDownList' => function ($id) {
            return $this->getDropDownList($id);
        },
        ]);

        if ($saved) {
            $this->redirect(array('list'));
        }

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
            'html'    => $this->renderAjax('crud/edit/_contentBlock', ['crudEdit' => $crudEdit]),
            'scripts' => $this->registerClientSideAjaxScript(),
            'title'   => $crudEdit->title,
            ];
        } else {
            return $this->render('crud/edit/edit', ['crudEdit' => $crudEdit]);
        }
    }


    protected function saveTaxCountry($countries, $tax) {
        if (empty($countries)) return true;
        $countries = (array) $countries;
        $saved = false;

        foreach ($countries as $country) {
            if (TaxCountry::findOne(['country_id' => $country, 'tax_id' => $tax])) continue;
            $taxCountry = new TaxCountry(['scenario' => 'insert']);
            $taxCountry->country_id = $country;
            $taxCountry->tax_id     = $tax;
            $saved &= $taxCountry->save();
        }
        return $saved;
    }
}