<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\base;

use yii\base\Event;

/**
 * Class ExtraDataEvent provide an Event with extra data
 *
 * @package kalibao\common\components\base
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ExtraDataEvent extends Event
{
    public $extraData;
}