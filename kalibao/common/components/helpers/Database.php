<?php
/**
 * @copyright Copyright (c) 2016 - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\helpers;


class Database
{
    public static function indexWithPrimaryKey(array $array, $key = 'id')
    {
        $result = [];
        foreach ($array as $item) {
            $result[$item[$key]] = $item;
        }
        return $result;
    }
}