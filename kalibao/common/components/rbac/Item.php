<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\rbac;

use yii\base\Object;

/**
 * Class Item
 *
 * @package kalibao\common\components\rbac
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Item extends Object
{
    /**
     * @var integer The type of the item. This should be either "role" or "permission".
     */
    public $type;
    /**
     * @var string The name of the item. This must be globally unique.
     */
    public $name;
    /**
     * @var string name of the rule associated with this item
     */
    public $ruleName;
    /**
     * @var mixed The additional data associated with this item
     */
    public $data;
}
