<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

/**
 * Class DateRangeItemField
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class DateRangeField extends ItemField
{
    /**
     * @inheritdoc
     */
    protected $fieldType = 'dateRange';

    /**
     * @var InputField
     */
    protected $_start;

    /**
     * @var InputField
     */
    protected $_end;

    /**
     * @return InputField
     */
    public function getEnd()
    {
        return $this->_end;
    }

    /**
     * @param InputField $end
     */
    public function setEnd(InputField $end)
    {
        $this->_end = $end;
    }

    /**
     * @return InputField
     */
    public function getStart()
    {
        return $this->_start;
    }

    /**
     * @param InputField $start
     */
    public function setStart(InputField $start)
    {
        $this->_start = $start;
    }
}