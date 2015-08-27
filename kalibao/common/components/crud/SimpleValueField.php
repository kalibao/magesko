<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use yii\db\ActiveRecord;

/**
 * Class SimpleValueField
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class SimpleValueField extends ItemField
{
    /**
     * @inheritdoc
     */
    protected $fieldType = 'simpleValue';

    /**
     * @var string Label value
     */
    protected $label;

    /**
     * @var string Field value
     */
    protected $value;

    /**
     * @var ActiveRecord Model field
     */
    protected $model;

    /**
     * @var string Attribute name
     */
    protected $attribute;

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param string $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return ActiveRecord
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param ActiveRecord $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
}