<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\export;

use yii\base\Object;
use yii\db\ActiveRecord;
use kalibao\common\components\crud\ModelFilterInterface;

/**
 * Class ActiveRecordCsv provide a component to extract a model in a CSV file
 *
 * @package kalibao\common\components\export
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
abstract class ActiveRecordCsv extends Object
{
    /**
     * @var ModelFilterInterface
     */
    protected $model;

    /**
     * @var mixed List of attributes or label
     *
     * [
     *  'attribute_1' => true,
     *  'attribute_2' => true,
     *  'label 1',
     *  'label 2'
     * ]
     *
     */
    protected $header;

    /**
     * @var array List of
     */
    protected $items;

    /**
     * @var array Upload configuration
     */
    protected $uploadConfig;

    /**
     * @var array Request parameters
     */
    protected $requestParams;

    /**
     * @var string Language
     */
    protected $language;

    /**
     * @var string Delimiter used to separate values
     */
    protected $delimiter = ';';

    /**
     * @var array List of rows used to build the csv file
     */
    private $rows;

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param ModelFilterInterface $model
     */
    public function setModel(ModelFilterInterface $model)
    {
        $this->model = $model;
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
     * Build the csv file
     * @param string $pathFile
     */
    public function save($pathFile)
    {
        $this->buildRows();

        $handle = @fopen($pathFile, 'w');
        if ($handle) {
            foreach ($this->rows as $row) {
                fputcsv($handle, $row, $this->delimiter);
            }
            fclose($handle);
        }
    }

    /**
     * Download csv file
     */
    public function download()
    {
        $pathFile = tempnam(sys_get_temp_dir(), 'export');
        $this->save($pathFile);
        $exportName = 'export-'.date('Y_m_d-H_i_s').'.csv';
        \Yii::$app->response->sendFile($pathFile, $exportName)->send();
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
     * Encode string
     * @param string $string
     * @return string
     */
    protected function encodeString($string)
    {
        return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $string);
    }

    /**
     * Build rows
     */
    protected function buildRows()
    {
        $this->rows = [];
        foreach($this->header as $attribute => $value) {
            if ($value === true) {
                $this->rows[0][] = $this->encodeString($this->model->getAttributeLabel($attribute));
            } else {
                $this->rows[0][] = $this->encodeString($value);
            }
        }

        foreach($this->model->search($this->requestParams, $this->language, 0)->getModels() as $model){
            $row = $this->getRow($model);
            foreach($row as &$it) {
                $it = $this->encodeString($it);
            }
            $this->rows[] = $row;
        }
    }

    /**
     * Get row
     * @param ActiveRecord $model
     * @return array
     */
    abstract protected function getRow(ActiveRecord $model);
}