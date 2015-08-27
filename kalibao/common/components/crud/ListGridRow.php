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
abstract class ListGridRow extends Object
{
    /**
     * @var \yii\db\ActiveRecord Model
     */
    protected $model;

    /**
     * @var string[] List of items
     */
    protected $items;

    /**
     * @var string Primary key
     */
    protected $pk;

    /**
     * @var bool Is translatable interface
     */
    protected $isTranslatable = true;

    /**
     * @var array Upload configuration
     */
    protected $uploadConfig;

    /**
     * @var array Request parameters
     */
    protected $requestParams;

    /**
     * Get model
     * @return \yii\db\ActiveRecord[]
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param \yii\db\ActiveRecord $models
     */
    public function setModel($models)
    {
        $this->model = $models;
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
     * @param bool $bool
     */
    public function setTranslatable($bool)
    {
        $this->isTranslatable = (bool) $bool;
    }

    /**
     * Check if interface is translatable
     * @return bool
     */
    public function isTranslatable()
    {
        return $this->isTranslatable;
    }

    /**
     * @return array
     */
    public function getPk()
    {
        if ($this->pk === null) {
            $this->pk = $this->model->getPrimaryKey(true);
        }
        return $this->pk;
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
}