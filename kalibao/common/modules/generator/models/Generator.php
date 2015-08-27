<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\modules\generator\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\db\Schema;
use yii\base\NotSupportedException;
use yii\helpers\Inflector;
use yii\web\View;

/**
 * Class EntryForm
 *
 * @package kalibao\common\modules\generator\models
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Generator extends Model
{
    /* Default version*/
    const DEFAULT_VERSION = '1.0';

    /* Input type */
    const TYPE_TEXT_INPUT = 1;
    const TYPE_TEXTAREA = 2;
    const TYPE_WYSIWYG_TEXTAREA = 3;
    const TYPE_FILE_INPUT = 4;
    const TYPE_IMAGE_INPUT = 11;
    const TYPE_DATE_INPUT = 5;
    const TYPE_DROP_DOWN = 6;
    const TYPE_ADVANCED_DROP_DOWN = 7;
    const TYPE_PRIMARY_KEY_AUTO = 8;
    const TYPE_DATE_AUTO = 9;
    const TYPE_CHECKBOX = 10;

    /* Database component  */
    public $db = 'db';

    /* Use table prefix */
    public $useTablePrefix = false;

    public $version;
    public $application;
    public $module;
    public $controller;
    public $translateGroup;
    public $table;

    private $tables;
    private $tableNames;
    private $classNames;
    private $relations;

    public function init()
    {
        parent::init();
        $this->version = self::DEFAULT_VERSION;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application', 'module', 'controller', 'translateGroup', 'table', 'version'], 'required'],
            [['application', 'module', 'controller', 'translateGroup', 'table', 'version'], 'string']
        ];
    }

    /**
     * Get Table names of the current schema
     * @return \string[]
     */
    public function getTableNames()
    {
        if (empty($this->tableNames)) {
            $this->tableNames = [];
            foreach ($this->getDbConnection()->schema->getTableNames() as $table) {
                $this->tableNames[$table] = $table;
            }
        }
        return $this->tableNames;
    }

    /**
     * Get table schema
     * @param string $table Table name
     * @return \yii\db\TableSchema
     */
    public function getTableSchema($table)
    {
        return $this->getDbConnection()->schema->getTableSchema($table);
    }

    /**
     * Generate module
     * @param array $requestColumns Request columns
     * @param array $requestPositions Request positions
     * @param array $requestRelations Request relations
     * @throws ErrorException
     */
    public function generate($requestColumns, $requestPositions, $requestRelations)
    {
        // generate relations
        $relations = $this->generateRelations($requestRelations);

        // generate module folders
        $this->generateModuleFolders();

        $tableName['main'] = $this->table;
        $tableName['i18n'] = $this->table.'_i18n';

        $className['main'] = $this->generateClassName($tableName['main']);
        $className['i18n'] = $this->generateClassName($tableName['i18n']);

        $configColumns['main'] = $this->getConfigColumns($className['main'], $requestRelations);
        if (isset($relations[$className['i18n']])) {
            $configColumns['i18n'] = $this->getConfigColumns($className['i18n'], $requestRelations);
        }

        // main model
        $params['main'] = [
            'tableName' => $tableName['main'],
            'className' => $className['main'],
            'columns' => $configColumns['main'],
            'tableLinks' => $this->getTableLinks($requestRelations),
            'tableSchema' => $this->tables[$className['main']],
            'isI18n' => false,
            'labels' => $this->generateLabels($this->tables[$className['main']]),
            'rules' => $this->generateMainRules($this->tables[$className['main']], $requestColumns),
            'scenarios' => $this->generateMainScenarios($this->tables[$className['main']], $requestColumns),
            'relations' => $relations,
            'namespace' => 'kalibao\\common\\models\\' . lcfirst($this->module),
        ];
        $this->saveFile(
            'models/'.lcfirst($this->controller).'/'.$className['main'].'.php',
            $this->render('models/Model.php', $params['main'])
        );

        // i18n model
        if (isset($relations[$className['i18n']])) {
            $params['i18n'] = [
                'tableName' => $tableName['i18n'],
                'className' => $className['i18n'],
                'columns' => $configColumns['i18n'],
                'tableLinks' => $this->getTableLinks($requestRelations),
                'tableSchema' => $this->tables[$className['i18n']],
                'isI18n' => true,
                'labels' => $this->generateLabels($this->tables[$className['i18n']]),
                'rules' => $this->generateI18nRules($this->tables[$className['i18n']], $requestColumns),
                'scenarios' => $this->generateI18nScenarios($this->tables[$className['i18n']]),
                'relations' => $relations,
                'namespace' => 'kalibao\\common\\models\\' . lcfirst($this->module),
            ];
            $this->saveFile(
                'models/' . lcfirst($this->controller) . '/' . $className['i18n'] . '.php',
                $this->render('models/Model.php', $params['i18n'])
            );
        }

        // filter model
        $configColumns['filter'] = $this->generateFilterColumns($requestColumns, $requestRelations, $relations);
        $params['filter'] = [
            'tableName' => $tableName['main'],
            'className' => $className['main'],
            'columns' => $configColumns['filter'],
            'tableLinks' => $this->getTableLinks($requestRelation),
            'extendedClass' => $className['main'],
            'use' => [
                'kalibao\\common\models\\'.$this->module.'\\'.$className['main'],
            ],
            'tableSchema' => $this->tables[$className['main']],
            'labels' => $this->generateLabels($this->tables[$className['main']]),
            'rules' => $this->generateFilterRules($className['main'], $configColumns['filter'], $requestColumns),
            'scenarios' => $this->generateFilterScenarios($className['main'], $configColumns['filter']),
            'relations' => isset($relations[$className['main']]) ? $relations[$className['main']] : null,
            'namespace' => 'kalibao\\' . $this->application . '\\modules\\' . lcfirst($this->module) .
                '\\models\\' . lcfirst($this->controller) . '\\crud'
        ];
        $this->saveFile(
            'models/'.lcfirst($this->controller).'/crud/ModelFilter.php',
            $this->render('models/crud/ModelFilter.php', $params['filter'])
        );

        // controller
        $params['controller'] = [
            'namespace' => 'kalibao\\' . $this->application . '\\modules\\' . lcfirst($this->module) .
                '\\controllers',
            'baseNamespaces' => 'kalibao\\' . $this->application . '\\modules\\' . lcfirst($this->module),
            'languageExist' => isset($relations[$className['i18n']]),
            'fileColumns' => $this->generateFileColumns($requestColumns, $relations),
            'dropDownLists' => $this->generateDropDownLists($requestColumns, $requestRelations, $relations),
            'advancedDropDownLists' => $this->generateAdvancedDropDownLists($requestColumns, $requestRelations, $relations),
        ];
        $this->saveFile(
            'controllers/'.$this->controller.'Controller.php',
            $this->render('controllers/Controller.php', $params['controller'])
        );

        // crud parameters
        $params['crud'] = [
            'namespace' => 'kalibao\\' . $this->application . '\\modules\\' . lcfirst($this->module) .
                '\\components\\'.lcfirst($this->controller).'\\crud' ,
            'columns' => $this->generateCrudColumns(
                $configColumns['main'],
                $requestColumns,
                $requestRelations,
                $requestPositions,
                $relations
            )
        ];

        // edit
        $this->saveFile(
            'components/'.lcfirst($this->controller).'/crud/Edit.php',
            $this->render('components/crud/Edit.php', $params['crud'])
        );

        // list grid
        $this->saveFile(
            'components/'.lcfirst($this->controller).'/crud/ListGrid.php',
            $this->render('components/crud/ListGrid.php', $params['crud'])
        );

        // list grid row
        $this->saveFile(
            'components/'.lcfirst($this->controller).'/crud/ListGridRow.php',
            $this->render('components/crud/ListGridRow.php', $params['crud'])
        );

        // list grid row edit
        $this->saveFile(
            'components/'.lcfirst($this->controller).'/crud/ListGridRowEdit.php',
            $this->render('components/crud/ListGridRowEdit.php', $params['crud'])
        );

        // export CSV
        $this->saveFile(
            'components/'.lcfirst($this->controller).'/crud/ExportCsv.php',
            $this->render('components/crud/ExportCsv.php', $params['crud'])
        );

        // setting
        $this->saveFile(
            'components/'.lcfirst($this->controller).'/crud/Setting.php',
            $this->render('components/crud/Setting.php', $params['crud'])
        );

        // translate
        $this->saveFile(
            'components/'.lcfirst($this->controller).'/crud/Translate.php',
            $this->render('components/crud/Translate.php', $params['crud'])
        );

        // module
        $this->saveFile(
            'Module.php',
            $this->render('Module.php', [
                'namespace' => 'kalibao\\' . $this->application . '\\modules\\' . lcfirst($this->module)
            ])
        );
    }

    /**
     * Generate drop down lists
     * @param array $requestColumns Request columns
     * @param array $requestRelations Request relations
     * @param array $relations Relations
     * @return array
     */
    public function generateDropDownLists(&$requestColumns, &$requestRelations, &$relations)
    {
        $dropDownList = [];
        foreach ($requestColumns as $name => $type) {
            $splitName = explode('.', $name);
            if ($type == self::TYPE_CHECKBOX && !isset($dropDownList['checkbox-drop-down-list'])) {
                $dropDownList['checkbox-drop-down-list'] = 'Html::checkboxInputFilterDropDownList();';
            } elseif ($type == self::TYPE_DROP_DOWN) {
                if (isset($requestRelations[$name])) {
                    $selectedRelation = null;
                    $relationName = null;

                    $reqRelationVal = $requestRelations[$name];
                    $reqRelationValSplit = explode('.', $reqRelationVal);

                    foreach ($relations[$splitName[0]] as $key => $relation) {
                        if ($relation[1] == $reqRelationValSplit[0]) {
                            $selectedRelation = $relation;
                            $relationName = $key;
                            break;
                        }
                    }

                    $isLanguage = substr($selectedRelation[1], -4, 4) === 'I18n';
                    $relatedClass = $relations[$splitName[0]][$relationName];

                    $pathClassName = $reqRelationValSplit[0];
                    if (substr($pathClassName, -4) == 'I18n') {
                        $pathClassName = lcfirst(substr($pathClassName, 0, -4)).'\\'.$pathClassName;
                    } else {
                        $pathClassName = lcfirst($pathClassName).'\\'.$pathClassName;
                    }
                    
                    $dropDownList[Inflector::camel2id($requestRelations[$name], '_')] = 'Html::findDropDownListData(
                        \'kalibao\\common\\models\\'.$pathClassName.'\',
                        [\''.($isLanguage ? key($relatedClass[4]) : reset($relatedClass[4])).'\', \''.$reqRelationValSplit[1].'\'],
                        ['.($isLanguage ? '[\'i18n_id\' => Yii::$app->language]' : '').']
                    );';
                }
            }
        }

        return $dropDownList;
    }

    /**
     * Generate advanced drop down lists
     * @param array $requestColumns Request columns
     * @param array $requestRelations Request relations
     * @param array $relations Relations
     * @return array
     */
    public function generateAdvancedDropDownLists(&$requestColumns, &$requestRelations, &$relations)
    {
        $dropDownList = [];
        foreach ($requestColumns as $name => $type) {
            $splitName = explode('.', $name);
            if ($type == self::TYPE_ADVANCED_DROP_DOWN) {
                if (isset($requestRelations[$name])) {
                    $selectedRelation = null;
                    $relationName = null;

                    $reqRelationVal = $requestRelations[$name];
                    $reqRelationValSplit = explode('.', $reqRelationVal);

                    foreach ($relations[$splitName[0]] as $key => $relation) {
                        if ($relation[1] == $reqRelationValSplit[0]) {
                            $selectedRelation = $relation;
                            $relationName = $key;
                            break;
                        }
                    }

                    $isLanguage = substr($selectedRelation[1], -4, 4) === 'I18n';
                    $relatedClass = $relations[$splitName[0]][$relationName];

                    $pathClassName = $reqRelationValSplit[0];
                    if (substr($pathClassName, -4) == 'I18n') {
                        $pathClassName = lcfirst(substr($pathClassName, 0, -4)).'\\'.$pathClassName;
                    } else {
                        $pathClassName = lcfirst($pathClassName).'\\'.$pathClassName;
                    }

                    $dropDownList[Inflector::camel2id($requestRelations[$name], '_')] = 'Html::findAdvancedDropDownListData(
                    \'kalibao\\common\\models\\'.$pathClassName.'\',
                    [\''.($isLanguage ? key($relatedClass[4]) : reset($relatedClass[4])).'\', \''.$reqRelationValSplit[1].'\'],
                    [[\'LIKE\', \''.$reqRelationValSplit[1].'\', $search]'.($isLanguage ? ', [\'i18n_id\' => Yii::$app->language]' : '').'],
                    10
                );';
                }
            }
        }

        return $dropDownList;
    }

    /**
     * Generate columns for Crud components
     * @param array $columns Main columns
     * @param array $requestColumns Request columns
     * @param array $requestRelations Request relations
     * @param array $requestPositions Positions of columns
     * @param array $relations Relations
     * @return array
     */
    public function generateCrudColumns($columns, &$requestColumns, &$requestRelations, &$requestPositions, &$relations)
    {
        $tableLinks = $this->getTableLinks($requestRelations);
        $mainClassName = $this->generateClassName($this->table);
        $columns = $this->reorderColumns($columns, $requestPositions);

        foreach ($columns as &$column) {
            $key = $column[0] . '.' . $column[1]->name;
            $column[2] = ($column[0] == $mainClassName) ? 'main' : 'i18n';
            $column[3] = $requestColumns[$key];
            if (isset($tableLinks[$column[1]->name])) {
                foreach ($tableLinks[$column[1]->name][1] as $data) {
                    if (isset($requestRelations[$key]) && $requestRelations[$key] == $data[0].'.'.$data[1]->name) {

                        $selectedRelation = null;
                        $relationName = null;
                        foreach ($relations[$column[0]] as $key => $relation) {
                            if ($relation[1] == $data[0]) {
                                $selectedRelation = $relation;
                                $relationName = $key;
                                break;
                            }
                        }

                        $isLanguage = substr($selectedRelation[1], -4, 4) === 'I18n';
                        $relatedClass = $relations[$column[0]][$relationName];

                        $column[4][0] = $data[0];
                        $column[4][1] = $data[1]->name;
                        $column[4][2] = $isLanguage;
                        $column[4][3] = $isLanguage ? key($relatedClass[4]) : reset($relatedClass[4]);

                        break;
                    }
                }
            }
        }

        return $columns;
    }

    /**
     * Reorder columns
     * @param array $columns Columns
     * @param array $requestPositions Positions of columns
     * @return array
     */
    public function reorderColumns($columns, &$requestPositions)
    {
        $reorderColumns = [];
        foreach ($columns as $column) {
            $key = $column[0] . '.' . $column[1]->name;
            if (isset($requestPositions[$key])) {
                $reorderColumns[$requestPositions[$key]] = $column;
            }
        }
        ksort($reorderColumns);
        return $reorderColumns;
    }

    /**
     * Generate file columns
     * @param array $requestColumns Request columns
     * @return array
     */
    public function generateFileColumns(&$requestColumns)
    {
        $columns = [];
        foreach ($requestColumns as $name => $type) {
            $splitName = explode('.', $name);
            if ($type == self::TYPE_FILE_INPUT || $type == self::TYPE_IMAGE_INPUT) {
                foreach ($this->tables[$splitName[0]]->columns as $column) {
                    if ($column->name == $splitName[1]) {
                        $columns[] = [
                            $type,
                            $column
                        ];
                        break;
                    }
                }
            }
        }

        return $columns;
    }

    /**
     * Generate column filters
     * @param array $requestColumns Request columns
     * @param array $requestRelations Request relations
     * @param array $relations Relations
     * @return array
     */
    public function generateFilterColumns(&$requestColumns, &$requestRelations, $relations)
    {
        $columns = [];
        foreach ($requestColumns as $key => $value) {
            $splitKey = explode('.', $key);
            $className = $splitKey[0];
            $attribute = $splitKey[1];

            if (isset($requestRelations[$key]) && in_array($requestColumns[$key],
                    [self::TYPE_ADVANCED_DROP_DOWN, self::TYPE_DROP_DOWN])) {
                $reqRelationVal = $requestRelations[$key];
                $reqRelationValSplit = explode('.', $reqRelationVal);

                if (isset($relations[$reqRelationValSplit[0]]) &&
                    !((isset($relations[$className][$reqRelationValSplit[0]]) &&
                        key($relations[$className][$reqRelationValSplit[0]][4]) == $attribute &&
                        reset($relations[$className][$reqRelationValSplit[0]][4]) == $reqRelationValSplit[1]))) {
                    $columns[] = [
                        $reqRelationValSplit[0],
                        $this->tables[$reqRelationValSplit[0]]->columns[$reqRelationValSplit[1]]
                    ];
                }
            }

            $columns[] = [
                $className,
                $this->tables[$className]->columns[$attribute]
            ];
        }

        return $columns;
    }

    /**
     * Save File
     * @param string $path Destination path
     * @param string $content Content
     */
    public function saveFile($path, $content)
    {
        $pathBase = Yii::getAlias('@kalibao/tmp/'.$this->module.'/'.$path);
        $mask = @umask(0);
        file_put_contents($pathBase, $content);
        @umask($mask);
    }

    /**
     * Generate module folders
     */
    public function generateModuleFolders()
    {
        $path = Yii::getAlias('@kalibao/tmp/'.lcfirst($this->module));
        $mask = @umask(0);
        @mkdir($path, 0777, true);
        @mkdir($path.'/components/'.lcfirst($this->controller).'/crud', 0777, true);
        @mkdir($path.'/controllers', 0777, true);
        @mkdir($path.'/models/'.lcfirst($this->controller).'/crud', 0777, true);
        @mkdir($path.'/views/'.Inflector::camel2id($this->controller).'/crud', 0777, true);
        @mkdir($path.'/views/'.Inflector::camel2id($this->controller).'/crud/edit', 0777, true);
        @mkdir($path.'/views/'.Inflector::camel2id($this->controller).'/crud/list', 0777, true);
        @mkdir($path.'/views/'.Inflector::camel2id($this->controller).'/crud/setting', 0777, true);
        @mkdir($path.'/views/'.Inflector::camel2id($this->controller).'/crud/translate', 0777, true);
        @umask($mask);
    }

    /**
     * Generates code using the specified code template and parameters.
     * Note that the code template will be used as a PHP file.
     * @param string $template the code template file. This must be specified as a file path
     * relative to [[templatePath]].
     * @param array $params list of parameters to be passed to the template file.
     * @return string the generated code
     */
    public function render($template, $params = [])
    {
        $view = new View();
        $params['generator'] = $this;
        return $view->renderFile(dirname((new \ReflectionClass($this))->getFileName()) . '/../resources/templates/' . $template, $params, $this);
    }

    /**
     * Get table links
     * @param array $requestRelations Request relations
     * @return array
     * @throws ErrorException
     */
    public function getTableLinks(&$requestRelations)
    {
        $className = $this->generateClassName($this->table);
        $columns = $this->getConfigColumns($className, $requestRelations);
        $relations = $this->relations[$className];

        $tableLinks = [];
        foreach ($columns as $d) {
            if ($d[0] == $className) {
                foreach ($relations as $k => $relation) {
                    if (count($relation[4]) == 1 && ($key = key($relation[4])) == $d[1]->name && $key != reset($relation[4])) {
                        $tableLinks[$key] = [
                            $relation[1],
                            $this->getConfigColumns($relation[1], $requestRelations)
                        ];
                    }
                }
            }
        }

        return $tableLinks;
    }

    /**
     * Get list of columns available in configurator
     * @param string $className Class name
     * @param array $requestRelations Request relations
     * @return array
     * @throws ErrorException
     * @throws NotSupportedException
     */
    public function getConfigColumns($className, &$requestRelations)
    {
        // refresh model
        $this->getDbConnection()->getSchema()->refresh();
        // generate relations
        $this->generateRelations($requestRelations);

        $columns = [];
        if (isset($this->tables[$className])) {
            foreach($this->tables[$className]->columns as $column) {
                $columns[] = [
                    $className,
                    $column
                ];
            }
        } else {
            throw new ErrorException();
        }

        $tableI18n = $this->generateClassName($this->tables[$className]->name.'_i18n');
        if (isset($this->tables[$tableI18n])) {

            foreach($this->tables[$tableI18n]->columns as $column) {
                if (! in_array($column->name, ['i18n_id', $this->tables[$className]->name.'_'.$this->tables[$className]->primaryKey[0]])) {
                    $columns[] = [
                        $tableI18n,
                        $column
                    ];
                }
            }
        }

        $end = [];
        foreach ($columns as $key => $column) {
            if (in_array($column[1]->name, ['created_at', 'updated_at'])) {
                $end[] = $column;
                unset($columns[$key]);
            }
        }

        $columns = array_merge($columns, $end);

        return $columns;
    }

    /**
     * Generate relations
     * @param array $requestRelations Request relations
     * @return array the generated relation declarations
     */
    public function generateRelations(&$requestRelations)
    {
        if (empty($this->relations)) {
            $db = $this->getDbConnection();
            if (($pos = strpos($this->table, '.')) !== false) {
                $schemaName = substr($this->table, 0, $pos);
            } else {
                $schemaName = '';
            }

            $this->relations = [];
            foreach ($db->getSchema()->getTableSchemas($schemaName) as $table) {
                $tableName = $table->name;

                $className = $this->generateClassName($tableName);
                $this->tables[$className] = $table;
                foreach ($table->foreignKeys as $refs) {
                    $refTable = $refs[0];
                    unset($refs[0]);
                    $fks = array_keys($refs);
                    $refClassName = $this->generateClassName($refTable);

                    // Add relation for this table
                    $link = $this->generateRelationLink(array_flip($refs));
                    $relationName = $this->generateRelationName($fks[0], false);
                    $this->relations[$className][$relationName] = [
                        "return \$this->hasOne($refClassName::className(), $link);",
                        $refClassName,
                        false,
                        $refTable,
                        $refs
                    ];

                    // Add relation for the referenced table
                    $hasMany = false;
                    if (count($table->primaryKey) > count($fks)) {
                        $hasMany = true;
                    } else {
                        foreach ($fks as $key) {
                            if (!in_array($key, $table->primaryKey, true)) {
                                $hasMany = true;
                                break;
                            }
                        }
                    }

                    $link = $this->generateRelationLink($refs);
                    $relationName = $this->generateRelationName($className, $hasMany);
                    $this->relations[$refClassName][$relationName] = [
                        "return \$this->" . ($hasMany ? 'hasMany' : 'hasOne') . "($className::className(), $link);",
                        $className,
                        $hasMany,
                        $tableName,
                        $refs,
                    ];
                }
            }

            foreach ($this->relations as $className => $tableRelations) {
                foreach ($tableRelations as $classNameRelation => $relation) {
                    if ($relation[2] == false && (substr_compare($className, 'I18n', -4, 4, true) !== 0)) {
                        foreach ($requestRelations as $reqRelKey => $reqRelVal) {
                            $aReqRelKey = explode('.', $reqRelKey);
                            if ($aReqRelKey[0] == $className) {
                                $aReqRelVal = explode('.', $reqRelVal);
                                if ($aReqRelKey[1] == $aReqRelVal[1]) {
                                    unset($requestRelations[$reqRelKey]);
                                    continue 2;
                                }
                            }
                        }

                        $i18nTableName = $relation[3] . '_i18n';
                        $i18nClassName = $this->generateClassName($i18nTableName);
                        $pluralize = Inflector::pluralize($i18nClassName);
                        if (isset($this->tables[$i18nClassName]) && !isset($this->relations[$className][$pluralize]) &&
                            $i18nClassName !== $className
                        ) {
                            $i18TableFK = $this->tables[$i18nClassName]->primaryKey;
                            unset($i18TableFK['i18n_id']);
                            $key = key($relation[4]);
                            $value = $i18TableFK[0];
                            $this->relations[$className][$pluralize] = [
                                "return \$this->hasMany($i18nClassName::className(), ['$value' => '$key']);",
                                $i18nClassName,
                                true,
                                $i18nTableName,
                                [$value => $key]
                            ];
                        }
                    }
                }
            }
        }

        return $this->relations;
    }

    /**
     * Generate a relation name for the specified table and a base name.
     * @param string $key a base name that the relation name may be generated from
     * @param boolean $multiple whether this is a has-many relation
     * @return string the relation name
     */
    protected function generateRelationName($key, $multiple)
    {
        if (!empty($key) && substr_compare($key, 'id', -2, 2, true) === 0 && strcasecmp($key, 'id')) {
            $key = rtrim(substr($key, 0, -2), '_');
        }
        if ($multiple) {
            $key = Inflector::pluralize($key);
        }
        return Inflector::id2camel($key, '_');
    }

    /**
     * Generates the link parameter to be used in generating the relation declaration.
     * @param array $refs reference constraint
     * @return string the generated link parameter.
     */
    protected function generateRelationLink($refs)
    {
        $pairs = [];
        foreach ($refs as $a => $b) {
            $pairs[] = "'$a' => '$b'";
        }

        return '[' . implode(', ', $pairs) . ']';
    }

    /**
     * Create a string from relation links between models
     * @param array $references Links between models
     * @return string
     */
    protected function createStringRelationLink($references)
    {
        $links = [];
        foreach ($references as $origin => $destination) {
            $links[] = "'$origin' => '$destination'";
        }
        return '['.implode(', ', $links).']';
    }

    /**
     * Generates a class name from the specified table name.
     * @param string $tableName the table name (which may contain schema prefix)
     * @return string the generated class name
     */
    public function generateClassName($tableName)
    {
        if (isset($this->classNames[$tableName])) {
            return $this->classNames[$tableName];
        }

        if (($pos = strrpos($tableName, '.')) !== false) {
            $tableName = substr($tableName, $pos + 1);
        }

        $db = $this->getDbConnection();
        $patterns = [];
        $patterns[] = "/^{$db->tablePrefix}(.*?)$/";
        $patterns[] = "/^(.*?){$db->tablePrefix}$/";
        if (strpos($this->table, '*') !== false) {
            $pattern = $this->table;
            if (($pos = strrpos($pattern, '.')) !== false) {
                $pattern = substr($pattern, $pos + 1);
            }
            $patterns[] = '/^' . str_replace('*', '(\w+)', $pattern) . '$/';
        }
        $className = $tableName;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $tableName, $matches)) {
                $className = $matches[1];
                break;
            }
        }

        return $this->classNames[$tableName] = Inflector::id2camel($className, '_');
    }

    /**
     * Get drop down list of column type
     * @param string $column Column name
     * @param bool $hasTableLink Has table link
     * @return array
     */
    public function getDropDownList($column, $hasTableLink = false)
    {
        $dropDownList = [];

        if ($column->isPrimaryKey && $hasTableLink == false) {
            if ($column->autoIncrement) {
                $dropDownList[self::TYPE_PRIMARY_KEY_AUTO] = 'Auto increment';
            } else {
                $dropDownList[self::TYPE_TEXT_INPUT] = 'Text input';
            }
        } else {
            if ($hasTableLink) {
                $dropDownList[self::TYPE_DROP_DOWN] = 'Drop down list';
                $dropDownList[self::TYPE_ADVANCED_DROP_DOWN] = 'Advanced drop down list';
            } else {
                if ($column->dbType == 'tinyint(1)' || $column->dbType == 'tinyint(1) unsigned') {
                    $dropDownList[self::TYPE_CHECKBOX] = 'Checkbox';
                } elseif (in_array($column->type, [
                        Schema::TYPE_SMALLINT,
                        Schema::TYPE_INTEGER,
                        Schema::TYPE_BIGINT,
                        Schema::TYPE_FLOAT,
                        Schema::TYPE_DOUBLE,
                        Schema::TYPE_DECIMAL,
                        Schema::TYPE_MONEY
                    ])) {
                    $dropDownList[self::TYPE_TEXT_INPUT] = 'Text input';
                } elseif (in_array($column->name, ['created_at', 'updated_at'])) {
                    $dropDownList[self::TYPE_DATE_AUTO] = 'Automatic date';
                } elseif (in_array($column->type, [Schema::TYPE_DATE, Schema::TYPE_DATETIME, Schema::TYPE_TIMESTAMP])) {
                    $dropDownList[self::TYPE_DATE_INPUT] = 'Date input';
                    $dropDownList[self::TYPE_TEXT_INPUT] = 'Text input';
                } else {
                    $dropDownList[self::TYPE_TEXT_INPUT] = 'Text input';
                    $dropDownList[self::TYPE_TEXTAREA] = 'Textarea input';
                    $dropDownList[self::TYPE_WYSIWYG_TEXTAREA] = 'Wysiwyg textarea input';
                    $dropDownList[self::TYPE_FILE_INPUT] = 'File input';
                    $dropDownList[self::TYPE_IMAGE_INPUT] = 'Image input';
                }
            }
        }
        return $dropDownList;
    }

    /**
     * Generate main scenarios
     * @param \yii\db\TableSchema $table the table schema
     * @param array $requestColumns Request columns
     * @return array
     */
    public function generateMainScenarios($table, $requestColumns)
    {
        $scenarios = [];

        $className = $this->generateClassName($table->name);
        foreach ($table->columns as $column) {
            $requestColumnRef = $requestColumns[$className . '.' . $column->name];
            if ($column->autoIncrement) {
                continue;
            }
            if ($requestColumnRef != self::TYPE_DATE_AUTO) {
                $scenarios['insert'][] = "'".$column->name."'";
                $scenarios['update'][] = "'".$column->name."'";
            }
        }

        if (!isset($scenarios['insert'])) {
            $scenarios['insert'] = [];
            $scenarios['update'] = [];
        }

        return $scenarios;
    }

    /**
     * Generate I18n scenarios
     * @param \yii\db\TableSchema $table the table schema
     * @return array
     */
    public function generateI18nScenarios($table)
    {
        $scenarios = [];

        foreach ($table->columns as $column) {
            if (!$column->isPrimaryKey) {
                $scenarios['insert'][] = "'".$column->name."'";
                $scenarios['update'][] = "'".$column->name."'";
                $scenarios['beforeInsert'][] = "'".$column->name."'";
                $scenarios['translate'][] = "'".$column->name."'";
            }
        }

        return $scenarios;
    }

    /**
     * Generate filter scenarios
     * @param string $mainClassName Main class name
     * @param array $columns Columns
     * @return array
     */
    public function generateFilterScenarios($mainClassName, $columns)
    {
        $scenarios = [];

        foreach ($columns as $data) {
            $className = $data[0];
            $column = $data[1];
            $columnName = ($className === $mainClassName) ? $column->name : Inflector::camel2id($className,
                    '_') . '_' . $column->name;

            if (in_array($column->name, ['created_at', 'updated_at'])) {
                $scenarios['default'][] = "'".$columnName.'_start'."'";
                $scenarios['default'][] = "'".$columnName.'_end'."'";
            } else {
                $scenarios['default'][] = "'".$columnName."'";
            }
        }

        return $scenarios;
    }

    /**
     * Generate rules of main table
     * @param \yii\db\TableSchema $table the table schema
     * @param array $requestColumns Request columns
     * @return array
     */
    public function generateMainRules($table, $requestColumns)
    {
        $types = [];
        $lengths = [];

        $className = $this->generateClassName($table->name);
        foreach ($table->columns as $column) {
            $requestColumnRef = $requestColumns[$className.'.'.$column->name];

            if ($column->autoIncrement) {
                continue;
            }

            if (!$column->allowNull && $column->defaultValue === null && $requestColumnRef != self::TYPE_FILE_INPUT
                && $requestColumnRef != self::TYPE_IMAGE_INPUT) {
                $types['required'][] = $column->name;
            }
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    if ($requestColumnRef == self::TYPE_CHECKBOX) {
                        $types['in']['[0, 1]'][] = $column->name;
                    } else {
                        $types['integer'][] = $column->name;
                    }
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                    $types['date']['yyyy-MM-dd'][] = $column->name;
                    break;
                case Schema::TYPE_TIME:
                    $types['date']['HH:mm:ss'][] = $column->name;
                    break;
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    if ($requestColumnRef != self::TYPE_DATE_AUTO) {
                        $types['date']['yyyy-MM-dd HH:mm:ss'][] = $column->name;
                    }
                    break;
                default: // strings
                    if ($requestColumnRef == self::TYPE_FILE_INPUT) {
                        $types['file'][] = $column->name;
                    } elseif ($requestColumnRef == self::TYPE_IMAGE_INPUT) {
                        $types['fileImage'][] = $column->name;
                    } elseif ($column->size > 0) {
                        $lengths[$column->size][] = $column->name;
                    } else {
                        $types['string'][] = $column->name;
                    }
            }
        }

        $rules = [];
        foreach ($types as $type => $columns) {
            if ($type === 'required') {
                $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
            } elseif ($type == 'file') {
                foreach ($columns as $column) {
                    $rules[] = '[\'' . $column . '\', \'file\', \'skipOnEmpty\' => false, \'when\' => function ($model) { return $model->'.$column.' == \'\'; }, \'whenClient\' => "function (attribute, value) { return $(attribute.input).attr(\'value\') === \'\' || $(attribute.input).attr(\'value\') === undefined; }"]';
                    $rules[] = '[\'' . $column . '\', \'file\', \'skipOnEmpty\' => true, \'when\' => function ($model) { return $model->'.$column.' !== \'\'; }, \'whenClient\' => "function (attribute, value) { return $(attribute.input).attr(\'value\') != \'\' && $(attribute.input).attr(\'value\') !== undefined; }"]';
                }
            } elseif($type == 'fileImage') {
                foreach ($columns as $column) {
                    $rules[] = '[\'' . $column . '\', \'file\', \'extensions\' => \'jpg, png\', \'mimeTypes\' => \'image/jpeg, image/png\', \'skipOnEmpty\' => false, \'when\' => function ($model) { return $model->'.$column.' == \'\'; }, \'whenClient\' => "function (attribute, value) { return $(attribute.input).attr(\'value\') === \'\' || $(attribute.input).attr(\'value\') === undefined; }"]';
                    $rules[] = '[\'' . $column . '\', \'file\', \'extensions\' => \'jpg, png\', \'mimeTypes\' => \'image/jpeg, image/png\', \'skipOnEmpty\' => true, \'when\' => function ($model) { return $model->'.$column.' !== \'\'; }, \'whenClient\' => "function (attribute, value) { return $(attribute.input).attr(\'value\') != \'\' && $(attribute.input).attr(\'value\') !== undefined; }"]';
                }
            } elseif($type === 'date') {
                foreach ($columns as $format => $cols) {
                    $rules[] = "[['" . implode("', '", $cols) . "'], 'date', 'format' => '$format']";
                }
            } elseif($type === 'in') {
                foreach ($columns as $range => $cols) {
                    $rules[] = "[['" . implode("', '", $cols) . "'], 'in', 'range' => $range]";
                }
            } else {
                $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
            }
        }
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }

        // Unique indexes rules
        try {
            $db = $this->getDbConnection();
            $uniqueIndexes = $db->getSchema()->findUniqueIndexes($table);
            foreach ($uniqueIndexes as $uniqueColumns) {
                // Avoid validating auto incremental columns
                if (!$this->isColumnAutoIncremental($table, $uniqueColumns)) {
                    $attributesCount = count($uniqueColumns);

                    if ($attributesCount == 1) {
                        $rules[] = "[['" . $uniqueColumns[0] . "'], 'unique']";
                    } elseif ($attributesCount > 1) {
                        $labels = array_intersect_key($this->generateLabels($table), array_flip($uniqueColumns));
                        $lastLabel = array_pop($labels);
                        $columnsList = implode("', '", $uniqueColumns);
                        $rules[] = "[['" . $columnsList . "'], 'unique', 'targetAttribute' => ['" . $columnsList . "'], 'message' => Yii::t('kalibao', 'The combination of " . implode(', ', $labels) . " and " . $lastLabel . " has already been taken.')]";
                    }
                }
            }
        } catch (NotSupportedException $e) {
            // doesn't support unique indexes information...do nothing
        }

        return $rules;
    }

    /**
     * Generate rules of i18n table
     * @param \yii\db\TableSchema $table the table schema
     * @param array $requestColumns Request columns
     * @return array
     */
    public function generateI18nRules($table, $requestColumns)
    {
        $types = [];
        $lengths = [];

        $className = $this->generateClassName($table->name);

        foreach ($table->columns as $column) {
            $requestColumnRef = isset($requestColumns[$className.'.'.$column->name]) ? $requestColumns[$className.'.'.$column->name] : null;

            if (!$column->allowNull && $column->defaultValue === null && $requestColumnRef != self::TYPE_FILE_INPUT
                && $requestColumnRef != self::TYPE_IMAGE_INPUT) {
                if ($column->isPrimaryKey) {
                    $types['required'][] = $column->name;
                } else {
                    $types['requiredBefore'][] = $column->name;
                }
            }
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    if ($requestColumnRef == self::TYPE_CHECKBOX) {
                        $types['in']['[0, 1]'][] = $column->name;
                    } else {
                        $types['integer'][] = $column->name;
                    }
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                    $types['date']['yyyy-MM-dd'][] = $column->name;
                    break;
                case Schema::TYPE_TIME:
                    $types['date']['HH:mm:ss'][] = $column->name;
                    break;
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    if ($requestColumnRef != self::TYPE_DATE_AUTO) {
                        $types['date']['yyyy-MM-dd HH:mm:ss'][] = $column->name;
                    }
                    break;
                default: // strings
                    if ($column->size > 0) {
                        $lengths[$column->size][] = $column->name;
                    } else {
                        $types['string'][] = $column->name;
                    }
            }
        }

        $rules = [];
        foreach ($types as $type => $columns) {
            if ($type === 'required') {
                $rules[] = "[['" . implode("', '", $columns) . "'], 'required', 'on' => ['insert', 'update', 'translate']]";
            } elseif ($type === 'requiredBefore') {
                $rules[] = "[['" . implode("', '", $columns) . "'], 'required']";
            } elseif($type === 'date') {
                foreach ($columns as $format => $cols) {
                    $rules[] = "[['" . implode("', '", $cols) . "'], 'date', 'format' => '$format']";
                }
            } elseif($type === 'in') {
                foreach ($columns as $range => $cols) {
                    $rules[] = "[['" . implode("', '", $cols) . "'], 'in', 'range' => $range]";
                }
            } else {
                $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
            }
        }
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }

        // Unique indexes rules
        try {
            $db = $this->getDbConnection();
            $uniqueIndexes = $db->getSchema()->findUniqueIndexes($table);
            foreach ($uniqueIndexes as $uniqueColumns) {
                // Avoid validating auto incremental columns
                if (!$this->isColumnAutoIncremental($table, $uniqueColumns)) {
                    $attributesCount = count($uniqueColumns);

                    if ($attributesCount == 1) {
                        $rules[] = "[['" . $uniqueColumns[0] . "'], 'unique']";
                    } elseif ($attributesCount > 1) {
                        $labels = array_intersect_key($this->generateLabels($table), array_flip($uniqueColumns));
                        $lastLabel = array_pop($labels);
                        $columnsList = implode("', '", $uniqueColumns);
                        $rules[] = "[['" . $columnsList . "'], 'unique', 'targetAttribute' => ['" . $columnsList . "'], 'message' => Yii::t('kalibao', 'The combination of " . implode(', ', $labels) . " and " . $lastLabel . " has already been taken.')]";
                    }
                }
            }
        } catch (NotSupportedException $e) {
            // doesn't support unique indexes information...do nothing
        }

        return $rules;
    }

    /**
     * Generate rules of filter model
     * @param string $mainClassName Main class name
     * @param array $columns Columns
     * @param array $requestColumns Request columns
     * @return array
     */
    public function generateFilterRules($mainClassName, $columns, $requestColumns)
    {
        $types = [];
        $lengths = [];

        foreach ($columns as $data) {
            $className = $data[0];
            $column = $data[1];
            $requestColumnRef = isset($requestColumns[$className.'.'.$column->name]) ? $requestColumns[$className.'.'.$column->name] : null;
            $columnName = ($className === $mainClassName) ? $column->name : Inflector::camel2id($className, '_').'_'.$column->name;

            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    if ($requestColumnRef == self::TYPE_CHECKBOX) {
                        $types['in']['[0, 1]'][] = $columnName;
                    } else {
                        $types['integer'][] = $columnName;
                    }
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $columnName;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $columnName;
                    break;
                case Schema::TYPE_DATE:
                    $types['date']['yyyy-MM-dd'][] = $columnName;
                    break;
                case Schema::TYPE_TIME:
                    $types['date']['HH:mm:ss'][] = $columnName;
                    break;
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    if (in_array($column->name, ['created_at', 'updated_at'])) {
                        $types['date']['yyyy-MM-dd'][] = $columnName.'_start';
                        $types['date']['yyyy-MM-dd'][] = $columnName.'_end';
                    } else {
                        $types['date']['yyyy-MM-dd HH:mm:ss'][] = $columnName;
                    }
                    break;
                default: // strings
                    if ($column->size > 0) {
                        $lengths[$column->size][] = $columnName;
                    } else {
                        $types['string'][] = $columnName;
                    }
            }
        }

        $rules = [];
        foreach ($types as $type => $columns) {
            if($type === 'date') {
                foreach ($columns as $format => $cols) {
                    $rules[] = "[['" . implode("', '", $cols) . "'], 'date', 'format' => '$format']";
                }
            } elseif($type === 'in') {
                foreach ($columns as $range => $cols) {
                    $rules[] = "[['" . implode("', '", $cols) . "'], 'in', 'range' => $range]";
                }
            } else {
                $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
            }
        }
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }

        return $rules;
    }

    /**
     * Generates the attribute labels for the specified table.
     * @param \yii\db\TableSchema $table the table schema
     * @return array the generated attribute labels (name => label)
     */
    public function generateLabels($table)
    {
        $labels = [];
        foreach ($table->columns as $column) {
            if (!empty($column->comment)) {
                $labels[$column->name] = $column->comment;
            } elseif (!strcasecmp($column->name, 'id')) {
                $labels[$column->name] = 'ID';
            } else {
                $label = Inflector::camel2words($column->name);
                if (!empty($label) && substr_compare($label, ' id', -3, 3, true) === 0) {
                    $label = substr($label, 0, -3) . ' ID';
                }
                $labels[$column->name] = $label;
            }
        }

        return $labels;
    }

    /**
     * Checks if any of the specified columns is auto incremental.
     * @param \yii\db\TableSchema $table the table schema
     * @param array $columns columns to check for autoIncrement property
     * @return boolean whether any of the specified columns is auto incremental.
     */
    protected function isColumnAutoIncremental($table, $columns)
    {
        foreach ($columns as $column) {
            if (isset($table->columns[$column]) && $table->columns[$column]->autoIncrement) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generates the table name by considering table prefix.
     * If [[useTablePrefix]] is false, the table name will be returned without change.
     * @param string $tableName the table name (which may contain schema prefix)
     * @return string the generated table name
     */
    public function generateTableName($tableName)
    {
        if (!$this->useTablePrefix) {
            return $tableName;
        }

        $db = $this->getDbConnection();
        if (preg_match("/^{$db->tablePrefix}(.*?)$/", $tableName, $matches)) {
            $tableName = '{{%' . $matches[1] . '}}';
        } elseif (preg_match("/^(.*?){$db->tablePrefix}$/", $tableName, $matches)) {
            $tableName = '{{' . $matches[1] . '%}}';
        }
        return $tableName;
    }

    /**
     * Get DB Connection
     * @return \yii\db\Connection
     */
    protected function getDbConnection()
    {
        return Yii::$app->get($this->db, false);
    }
} 