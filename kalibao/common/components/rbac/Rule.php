<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\rbac;

use yii\base\Object;

/**
 * Class Rule represents a business constraint that may be associated with a role, permission or assignment.
 *
 * @package kalibao\common\components\rbac
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
abstract class Rule extends Object
{
    /**
     * @var string name of the rule
     */
    public $name;

    /**
     * Executes the rule.
     *
     * @param string|integer $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[\kalibao\common\components\web\User::checkAccess()]].
     * @return boolean a value indicating whether the rule permits the auth item it is associated with.
     */
    abstract public function execute($user, $item, $params);
}
