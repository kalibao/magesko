<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use yii\base\Object;

/**
 * Class ListGridRow
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
abstract class ListGridRowEdit extends Object
{
    /**
     * @var \yii\base\Model[] Models
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
     * @var bool Enabled client validation
     */
    protected $clientValidationEnabled = true;

    /**
     * @var array Request parameters
     */
    protected $requestParams;

    /**
     * @var \Closure Drop down list method : function ($id) { return []; }
     */
    protected $dropDownList;

    /**
     * @var array Upload configuration
     */
    protected $uploadConfig;

    /**
     * Get models
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
     * @return array
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }

    /**
     * @param array $requestParams
     */
    public function setRequestParams($requestParams)
    {
        $this->requestParams = $requestParams;
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

}