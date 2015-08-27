<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\cms;

use Yii;
use yii\base\Object;
use yii\caching\TagDependency;

/**
 * Class CmsMenuSimpleService provide a system to manage pages
 *
 * @package kalibao\common\components\cms
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class CmsMenuSimpleService extends Object
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.cms_menu_simple';

    /**
     * @var int Cache duration
     */
    public static $cacheDuration = 86400;

    /**
     * Get cache tag
     * @param int|null $menuGroupId Menu group ID
     * @return string
     */
    public static function getCacheTag($menuGroupId = null)
    {
        $menuGroupId = (int) $menuGroupId;
        return md5(serialize([self::TAG_DEPENDENCY, $menuGroupId]));
    }

    /**
     * Refresh menu
     * @param int|null $menuGroupId
     */
    public static function refreshMenu($menuGroupId = null)
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($menuGroupId));
    }

    /**
     * Refresh menus
     */
    public static function refreshMenus()
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag());
    }
}