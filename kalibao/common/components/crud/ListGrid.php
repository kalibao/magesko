<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use Yii;
use yii\db\ActiveRecord;
use yii\base\InvalidParamException;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;

/**
 * Class ListGrid implements the common methods and properties to display a list of data
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class ListGrid extends Object
{
    /**
     * @var string Interface ID
     */
    protected $id;

    /**
     * @var string Interface title
     */
    protected $title;

    /**
     * @var array model
     */
    protected $model;

    /**
     * @var string Model name
     */
    protected $filterModelName;

    /**
     * @var array Request parameters
     */
    protected $requestParams;

    /**
     * @var string Language ID
     */
    protected $language;

    /**
     * @var int Page size
     */
    protected $pageSize;

    /**
     * @var string Page action in current controller
     */
    protected $defaultAction;

    /**
     * @var int Default page size
     */
    protected $defaultPageSize = 10;

    /**
     * @var array Head attributes of grid
     */
    protected $gridHeadAttributes;

    /**
     * @var ItemField[] Grid filters
     */
    protected $gridHeadFilters = [];

    /**
     * @var ItemField[] Advanced filters
     */
    protected $advancedFilters = [];

    /**
     * @var ListGridRow[] Rows
     */
    protected $gridRows = [];

    /**
     * @var string Component class of grid row
     */
    protected $gridRowComponentClass;

    /**
     * @var bool Enabled client validation
     */
    protected $clientValidationEnabled = true;

    /**
     * @var \Closure Drop down list method : function ($id) { return []; }
     */
    protected $dropDownList;

    /**
     * @var array Upload configuration
     */
    protected $uploadConfig;

    /**
     * @var bool Enable unique ID
     */
    protected $uniqueId = false;

    /**
     * @var bool Is translatable interface
     */
    protected $isTranslatable = true;

    private $dataProvider;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->getDataProvider();
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
     * @return array
     */
    public function getGridHeadAttributes()
    {
        return $this->gridHeadAttributes;
    }

    /**
     * @param array $attributes
     */
    public function setGridHeadAttributes($attributes)
    {
        $this->gridHeadAttributes = $attributes;
    }

    /**
     * @param int $pageSize
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        if ($this->pageSize === null) {
            $this->setPageSize($this->defaultPageSize);
        }
        return $this->pageSize;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $modelName Model name
     */
    public function setFilterModelName($modelName)
    {
        $this->filterModelName = $modelName;
    }

    /**
     * @param string $componentName Component name
     */
    public function setGridRowComponentClass($componentName)
    {
        $this->gridRowComponentClass = $componentName;
    }

    /**
     * @return ItemField[]
     */
    public function getGridHeadFilters()
    {
        return $this->gridHeadFilters;
    }

    /**
     * @param ItemField[] $filters
     */
    public function setGridHeadFilters($filters)
    {
        $this->gridHeadFilters = $filters;
    }

    /**
     * @return ItemField[] $advancedFilters
     */
    public function getAdvancedFilters()
    {
        return $this->advancedFilters;
    }

    /**
     * @param ItemField[] $advancedFilters
     */
    public function setAdvancedFilters($advancedFilters)
    {
        $this->advancedFilters = $advancedFilters;
    }

    /**
     * Get rows of grid
     * @param bool $refresh
     * @return ListGridRow[]
     */
    public function getGridRows($refresh = false)
    {
        if (empty($this->gridRows) || $refresh === true) {
            foreach ($this->getDataProvider($refresh)->getModels() as $models) {
                $gridRow = new $this->gridRowComponentClass([
                    'model' => $models,
                    'requestParams' => $this->getRequestParams(),
                    'uploadConfig' => $this->getUploadConfig(),
                    'translatable' => $this->isTranslatable()
                ]);
                $this->addRow($gridRow);
            }
        }
        return $this->gridRows;
    }

    /**
     * @param ListGridRow[] $rows
     */
    public function setGridRows($rows)
    {
        $this->gridRows = $rows;
    }

    /**
     * Add row
     * @param ListGridRow $row
     */
    protected function addRow(ListGridRow $row)
    {
        $this->gridRows[] = $row;
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

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        if (! Yii::$app->appLanguage->isValidLanguage($language)) {
            throw new InvalidParamException('Language is not valid.');
        }
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
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
     * Get data provider
     * @param bool $refresh Refresh parameters sent to the search method
     * @return ActiveDataProvider
     */
    public function getDataProvider($refresh = false)
    {
        if ($this->dataProvider === null || $refresh === true) {
            $this->dataProvider = $this->getModel()->search(
                $this->requestParams,
                $this->language,
                $this->pageSize
            );
            if ($this->defaultAction !== null) {
                $this->dataProvider->sort->route = $this->defaultAction;
                $this->dataProvider->pagination->route = $this->defaultAction;
            }
        }

        return $this->dataProvider;
    }

    /**
     * @return string
     */
    public function getDefaultAction()
    {
        return $this->defaultAction;
    }

    /**
     * @param string $pageAction
     */
    public function setDefaultAction($pageAction)
    {
        $this->defaultAction = $pageAction;
    }

    /**
     * @param ActiveRecord $model
     */
    public function setModel(ActiveRecord $model)
    {
        $this->model = $model;
    }


    /**
     * Get an instance of model
     * @return ActiveRecord
     */
    public function getModel()
    {
        return $this->model;
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