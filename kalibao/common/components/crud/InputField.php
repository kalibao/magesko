<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use kalibao\common\components\helpers\Html;

/**
 * Class InputField
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class InputField extends ItemField
{
    /**
     * @inheritdoc
     */
    protected $fieldType = 'input';

    /**
     * @var string Input id
     */
    protected $id;

    /**
     * @var string Type of field. If null the value parameter is displayed
     */
    protected $type;

    /**
     * @var array Data used to populate input field
     */
    protected $data;

    /**
     * @var array The tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     */
    protected $options = [];

    /**
     * @var boolean True if the input is required, False otherwise
     */
    protected $required;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->setOptions([]);
        }

        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options['data-validator-id'] = $this->getId();
        $this->options['id'] = false;
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId()
    {
        if ($this->id === null) {
            $inputID = Html::getInputId($this->model, $this->attribute);
            $this->id = 'inputfield-'.$inputID;
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
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }
}