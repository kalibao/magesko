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
 * Class Edit implements the common methods and properties to edit data of a model
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Edit extends Object
{
    /**
     * @var string Interface ID
     */
    protected $id;

    /**
     * @var \yii\db\ActiveRecord[] Models
     */
    protected $models;

    /**
     * @var string[] List of items
     */
    protected $items;

    /**
     * @var string Language
     */
    protected $language;

    /**
     * @var \Closure Drop down list method : function ($id) { return []; }
     */
    protected $dropDownList;

    /**
     * @var \Closure Drop down image list method : function ($id) { return []; }
     */
    protected $imageDropDown;

    /**
     * @var array Upload configuration
     */
    protected $uploadConfig;

    /**
     * @var boolean Save status
     */
    protected $saved;

    /**
     * @var string Create title
     */
    protected $createTitle;

    /**
     * @var string Update title
     */
    protected $updateTitle;

    /**
     * @var boolean
     */
    protected $hasErrors = false;

    /**
     * @var string Close action
     */
    protected $closeAction;

    /**
     * @var bool Enabled client validation
     */
    protected $clientValidationEnabled = true;

    /**
     * @var bool Enable add again button in the interface
     */
    protected $addAgain = false;

    /**
     * @var bool Enable unique ID
     */
    protected $uniqueId = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->findErrors($this->models);
    }

    /**
     * Find errors
     * @param $models
     */
    protected function findErrors($models)
    {
        // error status
        foreach ($models as $model) {
            if (is_array($model)) {
                $this->findErrors($model);
            } elseif ($this->hasErrors = $model->hasErrors()) {
                break;
            }
        }
    }

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
     * @return \yii\db\ActiveRecord[]
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param \yii\db\ActiveRecord $models
     */
    public function setModels($models)
    {
        $this->models = $models;
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
        return $this->models['main']->getPrimaryKey(true);
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
     * @return callable
     */
    public function getDropDownList()
    {
        return $this->dropDownList;
    }

    /**
     * @param callable $dropDownList
     */
    public function setDropDownList(\Closure $dropDownList)
    {
        $this->dropDownList = $dropDownList;
    }

    /**
     * @return callable
     */
    public function getImageDropDown()
    {
        return $this->imageDropDown;
    }

    /**
     * @param callable $imageDropDown
     */
    public function setImageDropDown(\Closure $imageDropDown)
    {
        $this->imageDropDown = $imageDropDown;
    }

    /**
     * @return string
     */
    public function getCreateTitle()
    {
        return $this->createTitle;
    }

    /**
     * @param string $createTitle
     */
    public function setCreateTitle($createTitle)
    {
        $this->createTitle = $createTitle;
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
     * @return string
     */
    public function getUpdateTitle()
    {
        return $this->updateTitle;
    }

    /**
     * @param string $updateTitle
     */
    public function setUpdateTitle($updateTitle)
    {
        $this->updateTitle = $updateTitle;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if ($this->models['main']->isNewRecord) {
            return $this->createTitle;
        }
        return $this->updateTitle;
    }

    /**
     * @return boolean
     */
    public function hasErrors()
    {
        return $this->hasErrors;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        if ($this->models['main']->isNewRecord) {
            return Url::to(['create', 'add-again' => (int) $this->addAgain]);
        }
        return Url::to(['update'] + $this->models['main']->getPrimaryKey(true));
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
     * @return boolean
     */
    public function getAddAgain()
    {
        return $this->addAgain;
    }

    /**
     * @param boolean $addAgain
     */
    public function setAddAgain($addAgain)
    {
        $this->addAgain = $addAgain;
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
     * @return array
     */
    public function getUploadConfig()
    {
        return $this->uploadConfig;
    }

    /**
     * @param array $uploadConfig
     */
    public function setUploadConfig($uploadConfig)
    {
        $this->uploadConfig = $uploadConfig;
    }

}