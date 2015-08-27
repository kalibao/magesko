<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\caching;

use yii\caching\MemCache;

/**
 * Class MemCached
 *
 * This class overload the MemCache component in order to use Memcached than Memcache
 *
 * @package kalibao\common\components\caching
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class MemCached extends MemCache
{
    /**
     * @inheritdoc
     */
    public $useMemcached = true;
}