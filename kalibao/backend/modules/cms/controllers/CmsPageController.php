<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\controllers;

use kalibao\common\models\languageGroup\LanguageGroupI18n;
use kalibao\common\models\languageGroupLanguage\LanguageGroupLanguage;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use kalibao\common\components\helpers\Html;
use kalibao\backend\components\crud\Controller;
use kalibao\common\models\cmsPageContent\CmsPageContent;
use kalibao\common\models\cmsPageContent\CmsPageContentI18n;
use kalibao\common\models\cmsLayout\CmsLayout;
use kalibao\common\models\cmsPage\CmsPage;
use kalibao\backend\modules\cms\components\cmsPage\crud\EditPageContents;
use kalibao\common\components\base\ExtraDataEvent;
use kalibao\common\components\cms\CmsPageService as CmsPageComponent;

/**
 * Class CmsPageController
 *
 * @package kalibao\backend\modules\cms\controllers
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsPageController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\cmsPage\CmsPage',
        'i18n' => 'kalibao\common\models\cmsPage\CmsPageI18n',
        'filter' => 'kalibao\backend\modules\cms\models\cmsPage\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => 'kalibao\backend\modules\cms\components\cmsPage\crud\Edit',
        'list' => 'kalibao\backend\modules\cms\components\cmsPage\crud\ListGrid',
        'listFields' => 'kalibao\backend\modules\cms\components\cmsPage\crud\ListGridRow',
        'listFieldsEdit' => 'kalibao\backend\modules\cms\components\cmsPage\crud\ListGridRowEdit',
        'exportCsv' => 'kalibao\backend\modules\cms\components\cmsPage\crud\ExportCsv',
        'translate' => 'kalibao\backend\modules\cms\components\cmsPage\crud\Translate',
        'setting' => 'kalibao\backend\modules\cms\components\cmsPage\crud\Setting',
    ];

    private $dropDownLists = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'translate' => ['get', 'post'],
                    'edit-row' => ['get', 'post'],
                    'refresh-row' => ['get'],
                    'export' => ['get'],
                    'delete-rows' => ['post'],
                    'advanced-drop-down' => ['get'],
                    'load-page-contents' => ['get'],
                    'refresh-pages' => ['post'],
                    'refresh-page' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'advanced-drop-down-list', 'settings', 'export'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('consult'), 'permission.consult:*'],
                    ],
                    [
                        'actions' => ['create', 'advanced-drop-down-list', 'upload', 'load-page-contents'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('create'), 'permission.create:*'],
                    ],
                    [
                        'actions' => [
                            'update', 'edit-row', 'advanced-drop-down-list', 'refresh-row', 'upload',
                            'load-page-contents', 'refresh-pages', 'refresh-page'
                        ],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('update'), 'permission.update:*'],
                    ],
                    [
                        'actions' => ['translate'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('translate'), 'permission.translate:*'],
                    ],
                    [
                        'actions' => ['delete-rows'],
                        'allow' => true,
                        'roles' => [$this->getActionControllerPermission('delete'), 'permission.delete:*'],
                    ]
                    // everything else is denied
                ],
            ],
        ];
    }

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
     * Refresh page
     */
    public function actionRefreshPage()
    {
        // request
        $request = Yii::$app->request;

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($request->isPost && ($pageId = $request->get('id', false))) {
            (new CmsPageComponent())->refreshPage($pageId, null, null);
            $success = true;
        } else {
            $success = false;
        }

        return [
            'html' => $this->renderPartial('crud/common/_refreshPages', ['success' => $success]),
        ];
    }

    /**
     * Refresh pages
     */
    public function actionRefreshPages()
    {
        // request
        $request = Yii::$app->request;

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($request->isPost) {
            (new CmsPageComponent())->refreshPages();
            $success = true;
        } else {
            $success = false;
        }

        return [
            'html' => $this->renderPartial('crud/common/_refreshPages', ['success' => $success]),
        ];
    }

    /**
     * Load page contents
     * @return array
     * @throws Exception
     */
    public function actionLoadPageContents()
    {
        // request
        $request = Yii::$app->request;

        // set response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        $layout = $request->get('layoutId', null);
        $page = $request->get('pageId', null);

        $models['pageContents'] = $this->loadPageContentsModels($layout, $page);

        $editPageContents = new EditPageContents([
            'language' => Yii::$app->language,
            'models' => $models,
        ]);

        return [
            'html' => $this->renderPartial('crud/edit/_pageContents', ['crudEdit' => $editPageContents]),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionTranslate()
    {
        // Test if language model is implemented
        if (!$this->modelExist('i18n')) {
            throw new NotSupportedException('Translate action is not active for this interface');
        }

        // request component
        $request = Yii::$app->request;

        // get primary key used to find model
        $modelClass = $this->crudModelsClass['main'];
        $primaryKey = $modelClass::primaryKey()[0];
        if (($value = $request->get($primaryKey, false)) === false || $value === '') {
            throw new InvalidParamException('Main model could not be found.');
        }

        // get groups of languages
        $languagesGroups = (new LanguageGroupI18n())->getGroupLanguageIndexedById(Yii::$app->language);

        // default language group ID
        $defaultLanguageGroupId = Yii::$app->variable->get(
            'kalibao', 'language_group_id:'.Yii::$app->appLanguage->languageGroupName
        );

        $languageGroupId = $request->get('language_group_id', null);
        if ($languageGroupId === null || ! isset($languagesGroups[$languageGroupId])) {
            $languageGroupId = $defaultLanguageGroupId;
        }

        // get languages of current language group
        $languageGroupLanguages = (new LanguageGroupLanguage())->getLanguageGroupLanguages(
            $languageGroupId, Yii::$app->language
        );

        $languageGroupLanguagesId = [];
        foreach ($languageGroupLanguages as $languageGroupLanguage) {
            $languageGroupLanguagesId[] = $languageGroupLanguage->language_id;
        }

        // get application languages
        $languages = Yii::$app->appLanguage->reorderLanguages(
            $languageGroupLanguagesId, Yii::$app->language
        );

        // load models
        $models = $this->loadTranslateModels($languages, [$primaryKey => $value]);
        $pageContentNumber = $this->loadPageContentsTranslateModels($languages, [$primaryKey => $value], $models);

        // save models
        $saved = false;
        if ($request->isPost) {
            $saved = $this->saveTranslateModels($models, $request->post());
        }

        $crudTranslate = new $this->crudComponentsClass['translate']([
            'modelClass' => $this->crudModelsClass['i18n'],
            'languagesGroups' => $languagesGroups,
            'languageGroupId' => $languageGroupId,
            'requestParams' => $request->get(),
            'pageContentNumber' => $pageContentNumber,
            'pageContentModel' => new CmsPageContentI18n(['scenario' => 'translate']),
            'models' => $models,
            'saved' => $saved,
            'pk' => [$primaryKey => $value],
            'language' => Yii::$app->language,
            'languages' => $languages,
        ]);

        if ($request->isAjax) {
            // set response format
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'html' => $this->renderAjax('crud/translate/_contentBlock', ['crudTranslate' => $crudTranslate]),
                'scripts' => $this->registerClientSideAjaxScript(),
                'title' => $crudTranslate->title,
            ];
        } else {
            return $this->render('crud/translate/translate', ['crudTranslate' => $crudTranslate]);
        }
    }

    /**
     * Load page contents translate models
     * @param array $languages Languages
     * @param array $primaryKey Primary key
     * @param array $models
     * @return bool|integer
     * @throws Exception
     */
    protected function loadPageContentsTranslateModels($languages, $primaryKey, array &$models)
    {
        $pageContentNumber = false;
        if (($cmsPage = CmsPage::find()->select([key($primaryKey), 'cms_layout_id'])->where($primaryKey)->one()) !== null) {
            $cmsLayout = CmsLayout::find()->select('max_container')->where(['id' => $cmsPage->cms_layout_id])->one();
            if ($cmsLayout !== null) {
                $pageContentNumber = $cmsLayout->max_container;

                for ($i = 1; $i <= $pageContentNumber; ++$i) {
                    foreach ($languages as $language) {
                        $models[$language]['CmsPageContentI18n'][$i] = new CmsPageContentI18n(['scenario' => 'insert']);
                        $models[$language]['CmsPageContentI18n'][$i]->i18n_id = $language;
                    }
                }

                if ($cmsPage->id !== null) {
                    $results = CmsPageContent::find()
                        ->joinWith([
                            'cmsPageContentI18ns' => function ($query) use ($languages) {
                                $query->onCondition(['cms_page_content_i18n.i18n_id' => $languages]);
                            }
                        ])
                        ->where(['cms_page_id' => $cmsPage->id])
                        ->indexBy('index')
                        ->all();

                    foreach ($models as $language => $data) {
                        foreach ($data['CmsPageContentI18n'] as $index => $model) {
                            if (isset($results[$index])) {
                                $models[$language]['CmsPageContentI18n'][$index]->cms_page_content_id = $results[$index]->id;
                                foreach ($results[$index]->cmsPageContentI18ns as $cmsPageContentI18n) {
                                    $models[$cmsPageContentI18n->i18n_id]['CmsPageContentI18n'][$index] = $cmsPageContentI18n;
                                    $models[$cmsPageContentI18n->i18n_id]['CmsPageContentI18n'][$index]->scenario = 'update';
                                }
                            }
                        }
                    }
                }
            } else {
                throw new Exception('No layout');
            }
        }

        return $pageContentNumber;
    }

    /**
     * @inheritdoc
     */
    protected function loadTranslateModels(array $languages, array $primaryKey)
    {
        /* @var ActiveRecord $model */
        $model = $this->crudModelsClass['main'];
        /* @var ActiveRecord $modelI18n */
        $modelI18n = $this->crudModelsClass['i18n'];
        $linkModelI18n = $this->getLinkModelI18n();

        if (($cmsPage = $model::find()->select([key($primaryKey)])->where($primaryKey)->one()) !== null) {
            $conditions[$linkModelI18n] = reset($primaryKey);
            $conditions['i18n_id'] = $languages;

            $models = [];
            foreach ($modelI18n::findAll($conditions) as $model) {
                $models[$model->i18n_id]['CmsPageI18n'] = $model;
            }

            foreach ($languages as $language) {
                if (!isset($models[$language]['CmsPageI18n'])) {
                    $models[$language]['CmsPageI18n'] = new $this->crudModelsClass['i18n'](['scenario' => 'translate']);
                    $models[$language]['CmsPageI18n']->i18n_id = $language;
                    $models[$language]['CmsPageI18n']->$linkModelI18n = $conditions[$linkModelI18n];
                } else {
                    $models[$language]['CmsPageI18n']->scenario = 'translate';
                }
            }

        } else {
            throw new ErrorException('Main model could not be found.');
        }

        return $models;
    }

    /**
     * @inheritdoc
     */
    protected function saveTranslateModels(array &$models, array $requestParams)
    {
        $success = false;

        $transaction = (new $this->crudModelsClass['i18n']())->getDb()->beginTransaction();
        try {
            $hasError = false;
            /* @var ActiveRecord[] $models */
            foreach ($models as $language => $model) {
                if (isset($requestParams[$language]['CmsPageI18n'])) {
                    $models[$language]['CmsPageI18n']->load($requestParams[$language]['CmsPageI18n'], '');
                }
                if (!$models[$language]['CmsPageI18n']->validate()) {
                    $hasError = true;
                }

                foreach ($models[$language]['CmsPageContentI18n'] as $index => $cmsPageContentI18n) {
                    $models[$language]['CmsPageContentI18n'][$index]->load($requestParams[$language]['CmsPageContentI18n'][$index], '');
                    if (!$models[$language]['CmsPageContentI18n'][$index]->validate()) {
                        $hasError = true;
                    }
                }
            }

            if (!$hasError) {
                foreach ($models as $language => $model) {
                    /* @var ActiveRecord $model */

                    if ($model['CmsPageI18n']->save()) {
                        $success = true;
                    } else {
                        $success = false;
                        break;
                    }

                    foreach ($model['CmsPageContentI18n'] as $index => $cmsPageContentI18n) {
                        if ($cmsPageContentI18n->save()) {
                            $success = true;
                        } else {
                            $success = false;
                            break 2;
                        }
                    }
                }
            } else {
                $success = false;
                throw new ErrorException();
            }

            if ($success) {
                $transaction->commit();
            } else {
                throw new ErrorException();
            }

        } catch(\Exception $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }
        }

        // trigger an event
        $this->trigger(self::EVENT_SAVE_TRANSLATE, new ExtraDataEvent([
            'extraData' => [
                'models' => $models,
                'success' => $success
            ]
        ]));

        return $success;
    }

    /**
     * @inheritdoc
     */
    protected function loadEditModels(array $primaryKey = [])
    {
        $models = [];

        $modelClass = $this->crudModelsClass['main'];
        if (!empty($primaryKey)) {
            $models['main'] = $modelClass::findOne($primaryKey);
            if ($models['main'] === null) {
                throw new InvalidParamException('Main model could not be found.');
            } else {
                $models['main']->scenario = 'update';
            }
        } else {
            $models['main'] = new $modelClass(['scenario' => 'insert']);
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

        if (!$models['main']->isNewRecord) {
            $models['pageContents'] = $this->loadPageContentsModels($models['main']->cms_layout_id, $models['main']->id);
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
            $validate['main'] = $models['main']->validate();
            if ($this->modelExist('i18n')) {
                $models['i18n']->load($requestParams);
            }

            // get uploaded file instance
            $oldFileNames['main'] = [];
            $this->getUploadedFileInstances($models, $oldFileNames, $requestParams);

            // validate model
            $validate['main'] = $models['main']->validate();
            $validate['i18n'] = true;
            $validate['pageContents'] = true;
            if ($this->modelExist('i18n')) {
                $validate['i18n'] = $models['i18n']->validate();
            }

            if (isset($requestParams['CmsPageContentI18n']) && $models['main']->cms_layout_id !== null) {
                if (!$models['main']->isNewRecord) {
                    $models['pageContents'] = $this->loadPageContentsModels($models['main']->cms_layout_id, $models['main']->id);
                } else {
                    $models['pageContents'] = $this->loadPageContentsModels($models['main']->cms_layout_id);
                }

                foreach ($models['pageContents'] as $index => $model) {
                    if ($models['pageContents'][$index]['main']->scenario !== 'delete') {
                        $models['pageContents'][$index]['i18n']->load($requestParams['CmsPageContentI18n'][$index], '');
                        if (!$models['pageContents'][$index]['i18n']->validate()) {
                            $validate['pageContents'] = false;
                        }
                    }
                }
            }

            if (! $validate['main'] || ! $validate['i18n'] || ! $validate['pageContents']) {
                throw new Exception();
            }

            if ($models['main']->save()) {
                if ($this->modelExist('i18n')) {
                    $models['i18n']->i18n_id = Yii::$app->language;
                    $models['i18n']->{$this->getLinkModelI18n()} = $models['main']->{$models['main']::primaryKey()[0]};
                    $models['i18n']->scenario = ($models['i18n']->scenario === 'beforeInsert') ? 'insert' : 'update';
                    if (!$models['i18n']->save()) {
                        throw new Exception();
                    }
                }

                if (isset($requestParams['CmsPageContentI18n']) && isset($models['pageContents'])) {
                    foreach ($models['pageContents'] as $index => $model) {
                        if ($model['main']->scenario === 'delete') {
                            $model['main']->delete();
                        } else {
                            $models['pageContents'][$index]['main']->cms_page_id = $models['main']->id;
                            if ($models['pageContents'][$index]['main']->save()) {
                                $models['pageContents'][$index]['i18n']->cms_page_content_id = $models['pageContents'][$index]['main']->id;
                                if (!$models['pageContents'][$index]['i18n']->save()) {
                                    throw new Exception();
                                }
                            } else {
                                throw new Exception();
                            }
                        }
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
     * Load page content models
     * @param integer $layout Layout ID
     * @param integer|null $page Page ID
     * @return array
     * @throws Exception
     */
    protected function loadPageContentsModels($layout, $page = null)
    {
        $cmsPageContents = [];
        $cmsLayout = CmsLayout::find()->select('max_container')->where(['id' => $layout])->one();

        if ($cmsLayout !== null) {
            for ($i = 1; $i <= $cmsLayout->max_container; ++$i) {
                $cmsPageContents[$i]['main'] = new CmsPageContent(['scenario' => 'insert']);
                $cmsPageContents[$i]['main']->index = $i;

                $cmsPageContents[$i]['i18n'] = new CmsPageContentI18n(['scenario' => 'beforeInsert']);
                $cmsPageContents[$i]['i18n']->i18n_id = Yii::$app->language;
            }

            if ($page !== null) {
                $results = CmsPageContent::find()
                    ->joinWith([
                        'cmsPageContentI18ns' => function ($query) {
                            $query->onCondition(['cms_page_content_i18n.i18n_id' => Yii::$app->language]);
                        }
                    ])
                    ->where(['cms_page_id' => $page])
                    ->all();

                foreach ($results as $result) {
                    $scenario = 'update';

                    if (!isset($cmsPageContents[$result->index]['main'])) {
                        $scenario = 'delete';
                    }

                    $cmsPageContents[$result->index]['main'] = $result;
                    $cmsPageContents[$result->index]['main']->scenario = $scenario;

                    if (isset($result->cmsPageContentI18ns[0])) {
                        $cmsPageContents[$result->index]['i18n'] = $result->cmsPageContentI18ns[0];
                        $cmsPageContents[$result->index]['i18n']->scenario = $scenario;
                    }
                }
            }
        } else {
            throw new Exception('No layout');
        }

        return $cmsPageContents;
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
            case 'cms_layout_i18n.name':
                return Html::findAdvancedDropDownListData(
                    'kalibao\common\models\cmsLayout\CmsLayoutI18n',
                    ['cms_layout_id', 'name'],
                    [['LIKE', 'name', $search], ['i18n_id' => Yii::$app->language]],
                    10
                );
                break;
            default:
                return [];
                break;
        }
    }
}