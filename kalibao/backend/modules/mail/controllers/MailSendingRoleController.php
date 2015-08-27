<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\mail\controllers;

use kalibao\common\components\validators\ClientSideValidator;
use Yii;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use yii\web\Response;

/**
 * Class MailSendingRoleController
 *
 * @package kalibao\backend\modules\mail\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MailSendingRoleController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\mailSendingRole\MailSendingRole',
        'filter' => 'kalibao\backend\modules\mail\models\mailSendingRole\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\mail\components\mailSendingRole\crud\Edit',
        'list' => 'kalibao\backend\modules\mail\components\mailSendingRole\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\mail\components\mailSendingRole\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\mail\components\mailSendingRole\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\mail\components\mailSendingRole\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\mail\components\mailSendingRole\crud\Translate',
        'setting' => 'kalibao\backend\modules\mail\components\mailSendingRole\crud\Setting',
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
    protected function registerClientSideAjaxScript()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function actionEditRow()
    {
        // request component
        $request = Yii::$app->request;
        // output
        $output = '';
        // validators
        $validators = [];
        // saved status
        $saved = false;

        if ($request->isAjax) {
            /* @var ActiveRecord $modelClass */
            $modelClass = $this->crudModelsClass['main'];

            // get primary key used to find model
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
                $saved = $this->saveEditModels($models, Yii::$app->request->post());
            }

            if ($saved) {
                // HACK - Change primary key argument
                foreach ($conditions as $key => $value) {
                    $_GET[$key] = $models['main']->$key;
                }
                // refresh data
                $output = $this->actionRefreshRow()['html'];
            } else {
                // create a component to display data
                $crudListFieldsEdit = new $this->crudComponentsClass['listFieldsEdit']([
                    'models' => $models,
                    'language' => Yii::$app->language,
                    'requestParams' => $request->get(),
                    'uploadConfig' => $this->uploadConfig,
                    'dropDownList' => function ($id) {
                        return $this->getDropDownList($id);
                    }
                ]);

                // get validators
                if ($crudListFieldsEdit->hasClientValidationEnabled()) {
                    $validators = ClientSideValidator::getClientValidators(
                        $crudListFieldsEdit->items, $this->getView()
                    );
                }

                // get output
                $output = $this->renderPartial(
                    'crud/list/_gridBodyRowEdit',
                    ['crudListFieldsEdit' => $crudListFieldsEdit]
                );
            }
        }

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'html' => $output,
            'validators' => $validators,
            'saved' => $saved
        ];
    }

    /**
     * List action
     * @return array|string
     */
    public function actionList()
    {
        // request component
        $request = Yii::$app->request;

        // create a component to display data
        $crudList = new $this->crudComponentsClass['list']([
            'model' => new $this->crudModelsClass['filter'](),
            'gridRowComponentClass' => $this->crudComponentsClass['listFields'],
            'translatable' => $this->modelExist('i18n'),
            'requestParams' => $request->get(),
            'language' => Yii::$app->language,
            'defaultAction' => Yii::$app->controller->action->getUniqueId(),
            'pageSize' => -1,
            'uploadConfig' => $this->uploadConfig,
            'dropDownList' => function ($id) {
                return $this->getDropDownList($id);
            }
        ]);

        if (Yii::$app->request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/list/_contentBlock', ['crudList' => $crudList]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudList->title
            ];
        } else {
            return $this->render('crud/list/list', ['crudList' => $crudList]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function loadEditModels(array $primaryKey = [])
    {
        $models = [];

        // request
        $request = Yii::$app->request;

        $modelClass = $this->crudModelsClass['main'];
        if (!empty($primaryKey)) {
            $models['main'] = $modelClass::findOne($primaryKey);
            if ($models['main'] === null) {
                throw new InvalidParamException('Main model could not be found.');
            } else {
                $models['main']->scenario = 'update';
            }
        } else {
            $models['main'] = new $modelClass();
            $models['main']->scenario = 'insert';
        }

        if ($mailTemplateId = $request->get('mail_template_id', false)) {
            $models['main']->mail_template_id = $mailTemplateId;
        }

        if ($this->modelExist('i18n')) {
            $models['i18n'] = new $this->crudModelsClass['i18n']();
            $models['i18n']->scenario = 'beforeInsert';

            if (!empty($primaryKey) && !$models['main']->isNewRecord) {
                $tmp = $models['i18n']::findOne([
                    $this->getLinkModelI18n() => $models['main']->{key($primaryKey)},
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
                case 'mail_template.id':
                    $this->dropDownLists['mail_template.id'] = Html::findDropDownListData(
                        'kalibao\common\models\mailTemplate\MailTemplate',
                        ['id', 'id'],
                        []
                    );
                    break;
                case 'mail_send_role_i18n.title':
                    $this->dropDownLists['mail_send_role_i18n.title'] = Html::findDropDownListData(
                        'kalibao\common\models\mailSendRole\MailSendRoleI18n',
                        ['mail_send_role_id', 'title'],
                        [['i18n_id' => Yii::$app->language]]
                    );
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
            case 'person.full_name':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\person\Person',
                    ['id', 'CONCAT(first_name, \' \', last_name) as full_name'],
                    [['LIKE', 'first_name', $search]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }
}