<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\components\web;

use Yii;

/**
 * Class User class override default User component to provide a specific RBAC system
 *
 * @package kalibao\backend\components\web
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class User extends \kalibao\common\components\web\User
{
    /**
     * Returns a value indicating whether the user is a guest (not authenticated).
     * @return boolean whether the current user is a guest.
     * @see getIdentity()
     */
    public function getIsGuest()
    {
        return $this->getIdentity() === null || !$this->hasPermission('navigate:backend');
    }
}
