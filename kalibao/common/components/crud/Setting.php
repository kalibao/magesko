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
 * Class Setting implements the common methods and properties to configure interface setting
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Setting extends Object
{
    /**
     * @var string Interface ID
     */
    protected $id;

    /**
     * @var ActiveRecord Model
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
     * @var \Closure Drop down list method : function ($id) { return []; }
     */
    protected $dropDownList;

    /**
     * @var array Upload configuration
     */
    protected $uploadConfig;

    /**
     * @var boolean Save status
     */
    protected $saved;

    /**
     * @var string Title
     */
    protected $title;

    /**
     * @var boolean
     */
    protected $hasErrors = false;

    /**
     * @var string Close action
     */
    protected $closeAction;

    /**
     * @var bool Enable unique ID
     */
    protected $uniqueId = false;

    /**
     * @var bool Enabled client validation
     */
    protected $clientValidationEnabled = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        // error status
        $this->hasErrors = $this->model->hasErrors();

        // items
        $items[] = new InputField([
            'model' => $this->model,
            'attribute' => 'page_size',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $this->model->getAttributeLabel('page_size'),
            ]
        ]);

        $this->setItems($items);
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
     * @return ActiveRecord[]
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param ActiveRecord $model
     */
    public function setModel(ActiveRecord $model)
    {
        $this->model = $model;
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
        return $this->model->getPrimaryKey(true);
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
            $this->setTitle(Yii::t('kalibao', 'settings_title'));
        }
        return $this->title;
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
}