<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\attribute\controllers;

use kalibao\backend\modules\attribute\components\attribute\crud\Edit;
use kalibao\common\components\base\ExtraDataEvent;
use kalibao\common\models\attribute\Attribute;
use kalibao\common\models\attribute\AttributeI18n;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\web\Response;

/**
 * Class AttributeController
 *
 * @package kalibao\backend\modules\attribute\controllers
 * @version 1.0
 */
class AttributeController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\attribute\Attribute',
        'i18n' => 'kalibao\common\models\attribute\AttributeI18n',
        'filter' => 'kalibao\backend\modules\attribute\models\attribute\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\attribute\components\attribute\crud\Edit',
        'list' => 'kalibao\backend\modules\attribute\components\attribute\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\attribute\components\attribute\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\attribute\components\attribute\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\attribute\components\attribute\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\attribute\components\attribute\crud\Translate',
        'setting' => 'kalibao\backend\modules\attribute\components\attribute\crud\Setting',
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
     * Load edit models
     * @param array $primaryKey Primary key
     * @return mixed
     * @throws InvalidParamException
     */
    protected function loadEditModels(array $primaryKey = [])
    {
        $models = [];

        if (!empty($primaryKey)) {
            $models['main'] = Attribute::findOne($primaryKey);
            if ($models['main'] === null) {
                throw new InvalidParamException('Main model could not be found.');
            } else {
                $models['main']->scenario = 'update';
            }
        } else {
            $models['main'] = new Attribute(['scenario' => 'insert']);
        }

        if ($this->modelExist('i18n')) {
            $models['i18n'] = new $this->crudModelsClass['i18n']();
            $models['i18n']->scenario = 'beforeInsert';

            if (!empty($primaryKey) && !$models['main']->isNewRecord) {
                $tmp = AttributeI18n::findOne([
                    'attribute_id' => $models['main']->id,
                    'i18n_id' => Yii::$app->language
                ]);

                if ($tmp !== null) {
                    $models['i18n'] = $tmp;
                    $models['i18n']->scenario = 'update';
                    unset($tmp);
                }
            }
        }

        return $models;
    }

    /**
     * @inheritdoc
     */
    protected function saveEditModels(array &$models, array $requestParams)
    {
        /* @var ActiveRecord[] $models */
        $success = false;
        $transaction = $models['main']->getDb()->beginTransaction();
        try {
            // load request
            $models['main']->load($requestParams);
            if ($this->modelExist('i18n')) {
                $models['i18n']->load($requestParams);
            }

            // get uploaded file instance
            $oldFileNames['main'] = [];
            $this->getUploadedFileInstances($models, $oldFileNames, $requestParams);

            // validate model
            $validate['main'] = $models['main']->validate();
            $validate['i18n'] = true;
            if ($this->modelExist('i18n')) {
                $validate['i18n'] = $models['i18n']->validate();
            }

            if (! $validate['main'] || ! $validate['i18n']) {
                throw new Exception();
            }

            if ($models['main']->save()) {
                if ($this->modelExist('i18n')) {
                    $models['i18n']->i18n_id = Yii::$app->language;
                    $models['i18n']->attribute_id = $models['main']->{$models['main']::primaryKey()[0]};
                    $models['i18n']->scenario = ($models['i18n']->scenario === 'beforeInsert') ? 'insert' : 'update';
                    if (!$models['i18n']->save()) {
                        throw new Exception();
                    }
                }

                // save | remove file
                $this->saveUploadedFileInstances($models, $oldFileNames);
            } else {
                throw new Exception();
            }

            // commit
            $transaction->commit();

            // update scenario
            $models['main']->scenario = 'update';
            if ($this->modelExist('i18n')) {
                $models['i18n']->scenario = 'update';
            }

            $success = true;
        } catch(Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }

            // restore uploaded file instances
            $this->restoreUploadedFileInstances($models);
        }

        // trigger an event
        $this->trigger(self::EVENT_SAVE_EDIT, new ExtraDataEvent([
            'extraData' => [
                'models' => $models,
                'success' => $success
            ]
        ]));

        return $success;
    }

    /**
     * Get the link between main model and i18n model
     */
    protected function getLinkModelI18n()
    {
        return 'attribute_id';
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
        $explode = explode('|', $id);
        $id = $explode[0];
        $attr_type = (isset($explode[1]))?$explode[1]:null;
        switch ($id) {
            case 'attribute_type_i18n.value':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\attributeType\AttributeTypeI18n',
                    ['attribute_type_id', 'value'],
                    [['LIKE', 'value', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            case 'attribute.value':
                $models = (new \yii\db\Query())
                    ->select(['concat(attribute_id, "|", value)', 'value'])
                    ->from('attribute')
                    ->leftJoin('attribute_i18n', '`attribute`.`id` = `attribute_i18n`.`attribute_id`')
                    ->where(['attribute_type_id' => $attr_type])
                    ->andWhere(['LIKE', 'value', $search])
                    ->andWhere(['i18n_id' => Yii::$app->language])
                    ->limit(10)
                    ->all();
                $attributeId = '';
                $attributeValue = '';

                if (!empty($models)) {
                    $keys = array_keys($models[0]);
                    $attributeId = $keys[0];
                    $attributeValue = isset($keys[1]) ? $keys[1] : $keys[0];
                }

                return Html::activeAdvancedDropDownListData($models, $attributeId, $attributeValue);
                break;
            default:
                return [];
                break;
        }
    }
}