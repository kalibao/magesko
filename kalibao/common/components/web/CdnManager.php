<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\web;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class CdnManager provide a CDN manager used from \kalibao\common\components\web\AssetBundle
 * and \kalibao\common\components\web\AssetManager components
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class CdnManager extends Component
{
    /**
     * @var array List of CDN
     */
    public $cdnBaseUrl = [];

    /**
     * Get base url from a list of CDN
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getBaseUrl()
    {
        if (empty($this->cdnBaseUrl)) {
            throw new InvalidConfigException('The list of cdn is empty. Please fill the $cdnBaseUrl array.');
        }
        shuffle($this->cdnBaseUrl);

        return $this->cdnBaseUrl[0];
    }
}