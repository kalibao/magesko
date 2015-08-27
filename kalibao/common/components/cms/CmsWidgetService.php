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
 * Class CmsWidgetService provide a system to manage cms widgets
 *
 * @package kalibao\common\components\cms
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class CmsWidgetService extends Object
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.cms_widget';

    /**
     * @var int Cache duration
     */
    public static $cacheDuration = 86400;

    /**
     * Return the widget tag name.
     * @param int $id Widget ID
     * @return string
     */
    public static function getCacheTag($id = null)
    {
        $id = (int) $id;
        return md5(serialize([self::TAG_DEPENDENCY, $id]));
    }

    /**
     * Refresh cms widgets
     */
    public static function refreshWidgets()
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag());
    }

    /**
     * Refresh cms widget
     * @param int $id Widget ID
     */
    public static function refreshWidget($id)
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($id));
    }
}