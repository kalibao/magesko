<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Object;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * Class translate implements the common methods and properties to translate model attributes
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Translate extends Object
{
    /**
     * @var string Interface ID
     */
    protected $id;

    /**
     * @var \yii\base\Model[] Models
     */
    protected $models;

    /**
     * @var string Model class
     */
    protected $modelClass;

    /**
     * @var ActiveRecord Model instance
     */
    protected $model;

    /**
     * @var string[] List of items
     */
    protected $items;

    /**
     * @var string Language
     */
    protected $language;

    /**
     * @var array List of languages
     */
    protected $languages = [];

    /**
     * @var array Primary key
     */
    protected $pk = [];

    /**
     * @var boolean Save status
     */
    protected $saved;

    /**
     * @var string Title
     */
    protected $title;

    /**
     * @var string Close action
     */
    protected $closeAction;

    /**
     * @var bool Enabled client validation
     */
    protected $clientValidationEnabled = true;

    /**
     * @var bool Enable unique ID
     */
    protected $uniqueId = false;

    /**
     * @var array Request parameters
     */
    protected $requestParams;

    /**
     * @var string Scenario used in model
     */
    protected $scenario = 'translate';

    /**
     * @var \yii\db\ActiveRecord[] Groups of languages
     */
    public $languagesGroups;

    /**
     * @var integer Language group ID
     */
    public $languageGroupId;

    /**
     * Get ID interface
     * @return string
     */
    public function getId()
    {
        if ($this->id === null) {
            $this->setId(
                Inflector::underscore((new \ReflectionClass(__CLASS__))->getShortName()). '-' .
                Inflector::underscore(Inflector::id2camel(Yii::$app->controller->action->getUniqueId(),'/')).
                ($this->isUniqueId() ? '-'. uniqid() : '')
            );
        }
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get model
     * @return ActiveRecord[]
     */
    public function getModel()
    {
        if ($this->model === null) {
            $this->model = new $this->modelClass(['scenario' => $this->scenario]);
        }
        return $this->model;
    }

    /**
     * @param ActiveRecord[] $models
     */
    public function setModels(array $models)
    {
        $this->models = $models;
    }

    /**
     * @return ActiveRecord[]
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @return string[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getPk()
    {
        return $this->pk;
    }

    /**
     * @param array $pk
     */
    public function setPk($pk)
    {
        $this->pk = $pk;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return boolean
     */
    public function isSaved()
    {
        return $this->saved;
    }

    /**
     * @param boolean $saved
     */
    public function setSaved($saved)
    {
        $this->saved = $saved;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if ($this->title === null) {
            $this->setTitle(Yii::t('kalibao', 'translate_title'));
        }
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCloseAction()
    {
        if ($this->closeAction === null) {
            $this->closeAction = Url::to(['list']);
        }
        return $this->closeAction;
    }

    /**
     * @param string $closeAction
     */
    public function setCloseAction($closeAction)
    {
        $this->closeAction = $closeAction;
    }

    /**
     * @return boolean
     */
    public function hasClientValidationEnabled()
    {
        return $this->clientValidationEnabled;
    }

    /**
     * @param boolean $clientValidationEnabled
     */
    public function setClientValidationEnabled($clientValidationEnabled)
    {
        $this->clientValidationEnabled = $clientValidationEnabled;
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return $this->modelClass;
    }

    /**
     * @param string $modelClass
     */
    public function setModelClass($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param array $languages
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
    }

    /**
     * @param string $scenario
     * @return array
     */
    public function getItemsWithScenario($scenario)
    {
        $items = [];
        foreach ($this->getItems() as $item) {
            if ($item->model instanceof Model) {
                $item->model->scenario = $scenario;
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @return string
     */
    public function getScenario()
    {
        return $this->scenario;
    }

    /**
     * @param string $scenario
     */
    public function setScenario($scenario)
    {
        $this->scenario = $scenario;
    }

    /**
     * @return boolean
     */
    public function isUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param boolean $uniqueId
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;
    }

    /**
     * @param array $params
     */
    public function setRequestParams(array $params)
    {
        $this->requestParams = $params;
    }

    /**
     * @return array
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }
}