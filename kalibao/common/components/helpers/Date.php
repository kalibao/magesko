<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\helpers;

/**
 * Class Date provides helper functions to deal with dates
 *
 * @package kalibao\common\components\helpers
 * @version 1.0
 * @author Cassian Assael <cassian_as@yahoo.fr>
 */
class Date {

    /**
     * Function to convert date string into a MySQL datetime.
     *
     * @param $date string The date to convert
     * Supported input formats are d-m-yyyy, dd-mm-yyyy, yyyy-mm-dd, yyyy-m-d
     * Supported delimiters are . / - _ and space
     *
     * @return      string The date converted in the MySQL datetime format
     */
    public static function dateToMysql($date)
    {
        if (preg_match("/(\d{1,2})[-_\/\.\ ](\d{1,2})[-_\/\.\ ](\d{4})/", $date, $result)) { //french format
            $date = $result[3] . '-' . sprintf('%02d', $result[2]) . '-' . sprintf('%02d', $result[1]) . ' 00:00:00';
        } else { // english format
            preg_match("/(\d{4})[-_\/\.\ ](\d{1,2})[-_\/\.\ ](\d{1,2})/", $date, $result);
            $date = $result[1] . '-' . sprintf('%02d', $result[2]) . '-' . sprintf('%02d', $result[3]) . ' 00:00:00';
        }

        return $date;
    }
}