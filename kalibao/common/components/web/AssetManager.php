<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\web;

use Yii;

/**
 * Class AssetManager overload the default AssetManager component in order to add a CDN manager
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class AssetManager extends \yii\web\AssetManager
{
    /**
     * @var bool Use a cdn to provide assets. AssetManager use the component \kalibao\common\components\web\CdnManager
     * to process this action
     */
    public $useCdn = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->useCdn) {
            $this->baseUrl = Yii::$app->cdnManager->getBaseUrl() . '/'.
                Yii::getAlias('@kalibao/app') . '/'. $this->baseUrl;
        } else {
            $this->baseUrl = '/'. $this->baseUrl;
        }
    }
}
