<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\i18n;

/**
 * Class I18N overload the default I18N component in order to add new features.
 *
 * @version 1.0
 * @package kalibao\common\components\i18n
 * @author Kévin Walter <walkev13@gmail.com>
 */
class I18N extends \yii\i18n\I18N
{
    const DATE_FORMAT = 1;
    const DATETIME_FORMAT = 2;

    /**
     * Get date format of current language
     * @param int $date
     * @param string $forceLanguage
     * @return string
     */
    public static function getDateFormat($date = self::DATETIME_FORMAT, $forceLanguage = null)
    {
        $lang = ($forceLanguage === null)?\Yii::$app->language:$forceLanguage;
        switch($lang)
        {
            case 'fr':
            case 'fr_FR':
                if ($date == self::DATETIME_FORMAT) {
                    return 'dd MM yyyy, HH:mm:ss';
                } elseif ($date == self::DATE_FORMAT) {
                    return 'dd MM yyyy';
                }
            case 'datepicker':
                return 'dd/MM/yyyy';
            default:
                if ($date == self::DATETIME_FORMAT) {
                    return 'MM dd, yyyy hh:mm:ss a';
                } elseif ($date == self::DATE_FORMAT) {
                    return 'MM dd, yyyy';
                }
        }
    }

    /**
     * Get language label from id
     * @param string $language Language ID
     * @return string
     */
    public static function label($language)
    {
        return \Yii::t('kalibao', 'i18n_' . $language);
    }
}
