<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\components\web;

use Yii;

/**
 * Class UrlManager overload the default UrlManager component in order to add new rules and add language support
 *
 * @package kalibao\frontend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class UrlManager extends \yii\web\UrlManager
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $languages = Yii::$app->appLanguage->getAppLanguages();
        $joinLanguages = implode('|', $languages);
        $this->rules = [
            '/' => '/'.Yii::$app->language,
            '<language:'.$joinLanguages.'>/<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>' => '<module>/<controller>/<action>',
            '<language:'.$joinLanguages.'>/<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<controller>/<action>',
            '<language:'.$joinLanguages.'>/<controller:[\w\-]+>/<action:[\w\-]+>' => '<controller>/<action>',
            '<language:'.$joinLanguages.'>/<controller>' => '<controller>',
        ];
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function createUrl($params)
    {
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }

        return parent::createUrl($params);
    }
}