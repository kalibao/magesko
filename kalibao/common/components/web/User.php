<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\web;

use Yii;
use yii\base\InvalidConfigException;
use yii\caching\TagDependency;
use kalibao\common\components\rbac\Permission;
use kalibao\common\components\rbac\Role;
use kalibao\common\models\rbacUserRole\RbacUserRole;
use kalibao\common\components\rbac\Item;
use kalibao\common\components\rbac\Rule;

/**
 * Class User class override default User component to provide a specific RBAC system
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class User extends \yii\web\User
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.user_dependency';

    /**
     * @var int Cache duration
     */
    public $cacheDuration = 86400;

    /**
     * @var Item[] List of items belong to user
     */
    protected $items;

    /**
     * @var Rule[] List of rules belong to user
     */
    protected $rules;

    /**
     * @var array Cache access right
     */
    private $access;

    /**
     * @inheritdoc
     */
    public $enableAutoLogin = true;

    /**
     * @inheritdoc
     */
    public $loginUrl = ['authentication/authentication/login'];

    /**
     * Checks if the user can perform the operation as specified by the given permission.
     *
     * Note that you must configure "authUserManager" application component in order to use this method.
     * Otherwise an exception will be thrown.
     *
     * @param string $permissionName the name of the permission (e.g. "permission.create:*") that needs access check.
     * @param array $params name-value pairs that would be passed to the rules associated
     * with the roles and permissions assigned to the user. A param with name 'user' is added to
     * this array, which holds the value of [[id]].
     * @param boolean $allowCaching whether to allow caching the result of access check.
     * When this parameter is true (default), if the access check of an operation was performed
     * before, its result will be directly returned when calling this method to check the same
     * operation. If this parameter is false, this method will always call checkAccess() to obtain the up-to-date access result. Note that this
     * caching is effective only within the same request and only works when `$params = []`.
     * @return boolean whether the user can perform the operation as specified by the given permission.
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if ($allowCaching && empty($params) && isset($this->access[$permissionName])) {
            return $this->access[$permissionName];
        }

        $access = $this->checkAccess($permissionName, $params);

        if ($allowCaching && empty($params)) {
            $this->access[$permissionName] = $access;
        }

        return $access;
    }

    /**
     * Checks if the user can perform the operations as specified by minimum one of given permissions.
     *
     * @param mixed $permissionsNames array of permissions names
     * @param array $params name-value pairs for each permission name that would be passed to the rules associated
     * with the roles and permissions assigned to the user. A param with name 'user' is added to
     * this array, which holds the value of [[id]].
     * @param boolean $allowCaching whether to allow caching the result of access check.
     * When this parameter is true (default), if the access check of an operation was performed
     * before, its result will be directly returned when calling this method to check the same
     * operation. If this parameter is false, this method will always call checkAccess() to obtain the up-to-date access result. Note that this
     * caching is effective only within the same request and only works when `$params = []`.
     * @return boolean
     */
    public function canMultiple($permissionsNames, $params = [], $allowCaching = true)
    {
        foreach ($permissionsNames as $permissionName) {
            if ($this->can($permissionName, isset($params[$permissionName]) ? $permissionName : [], $allowCaching)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the user can perform the operation as specified by the given permission.
     *
     * @param string $permissionName The name of the permission that can be a role or a permission.
     * The name must contain the prefix item.
     * @param array $params name-value pairs that will be passed to the rules associated
     * with the roles and permissions assigned to the user.
     * @return bool
     * @throws InvalidConfigException
     */
    public function checkAccess($permissionName, $params = [])
    {
        if (($item = $this->getItem($permissionName)) === null) {
            return false;
        }

        if (!$this->executeRule($item, $params)) {
            return false;
        }

        return true;
    }

    /**
     * Checks if the user has role
     *
     * @param string $role Role name
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->getItem('role.'.$role) !== null;
    }

    /**
     * Checks if the user has permission
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->getItem('permission.'.$permission) !== null;
    }

    /**
     * Assign right to the current user
     */
    public function assignUserAuth()
    {
        $cacheKey = 'user_auth:' . $this->getId();

        $auth = Yii::$app->commonCache->get($cacheKey);
        if ($auth === false) {
            $rbacUserRoles = RbacUserRole::find()
                ->where(['user_id' => $this->id])
                ->with([
                    'rbacRole' => function ($query) {
                        $query->select(['id', 'name', 'rule_path']);
                    },
                    'rbacRole.rbacRolePermissions',
                    'rbacRole.rbacRolePermissions.rbacPermission'
                ])->all();

            $auth = ['items' => [], 'rules' => []];
            foreach ($rbacUserRoles as $rbacUserRole) {
                $roleName = 'role.'.$rbacUserRole->rbacRole->name;
                if (!isset($auth['items'][$roleName])) {
                    $auth['items'][$roleName] = new Role([
                        'name' => $roleName
                    ]);
                    if ($rbacUserRole->rbacRole->rule_path != '') {
                        $rule = new $rbacUserRole->rbacRole->rule_path();
                        if (!isset($auth['rules'][$rule->name])) {
                            $auth['rules'][$rule->name] = $rule;
                        }
                        $auth['items'][$roleName]->ruleName = $rule->name;
                        unset($rule);
                    }
                }
                if (isset($rbacUserRole->rbacRole->rbacRolePermissions)) {
                    foreach ($rbacUserRole->rbacRole->rbacRolePermissions as $rbacRolePermission) {
                        $permissionName = 'permission.'.$rbacRolePermission->rbacPermission->name;
                        if (!isset($auth['items'][$permissionName])) {
                            $auth['items'][$permissionName] = new Permission([
                                'name' => $permissionName
                            ]);
                        }
                        if ($rbacRolePermission->rbacPermission->rule_path != '' &&
                            class_exists($rbacRolePermission->rbacPermission->rule_path)) {
                            $rule = new $rbacRolePermission->rbacPermission->rule_path();
                            if (!isset($auth['rules'][$rule->name])) {
                                $auth['rules'][$rule->name] = $rule;
                            }
                            $auth['items'][$permissionName]->ruleName = $rule->name;
                            unset($rule);
                        }
                    }
                }
            }

            Yii::$app->commonCache->set(
                $cacheKey,
                $auth,
                $this->cacheDuration,
                new TagDependency([
                    'tags' => [self::getCacheTag(), self::getCacheTag($this->id)],
                ])
            );
        }

        $this->items = $auth['items'];
        $this->rules = $auth['rules'];
    }

    /**
     * Returns the cache tag name.
     * @param int $user User ID
     * @return string
     */
    public static function getCacheTag($user = null)
    {
        if ($user !== null) {
            $user = (int) $user;
        }
        return md5(serialize([self::TAG_DEPENDENCY, $user]));
    }

    /**
     * Refresh authorization for an user
     * @param int $user User ID
     */
    public function refreshUserAuth($user)
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($user));
    }

    /**
     * Refresh authorizations for all users
     */
    public function refreshAllUsersAuth()
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag());
    }

    /**
     * Get Item
     *
     * @param string $name Permission name or role name
     * @return null|Item
     */
    public function getItem($name)
    {
        if ($this->items === null) {
            $this->assignUserAuth();
        }
        return isset($this->items[$name]) ? $this->items[$name] : null;
    }

    /**
     * Get Rule
     *
     * @param string $name Name of rule
     * @return null|Rule
     */
    public function getRule($name)
    {
        return isset($this->rules[$name]) ? $this->rules[$name] : null;
    }

    /**
     * Executes the rule associated with the specified auth item.
     *
     * If the item does not specify a rule, this method will return true. Otherwise, it will
     * return the value of [[Rule::execute()]].
     *
     * @param Item $item the auth item that needs to execute its rule
     * @param array $params parameters passed to [[RBACUserManager::checkAccess()]] and will be passed to the rule
     * @return boolean the return value of [[Rule::execute()]]. If the auth item does not specify a rule, true will be returned.
     * @throws InvalidConfigException if the auth item has an invalid rule.
     */
    public function executeRule(Item $item, $params)
    {
        if ($item->ruleName != '') {
            $rule = $this->getRule($item->ruleName);
            if ($rule instanceof Rule) {
                $result = $rule->execute(Yii::$app->user->getId(), $item, $params);
                if ($result === false) {
                    return false;
                }
            } else {
                throw new InvalidConfigException("Rule not found: {$item->ruleName}");
            }
        }

        return true;
    }
}
