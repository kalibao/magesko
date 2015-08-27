<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\caching\TagDependency;
use kalibao\common\models\interfaceSetting\InterfaceSetting as ModelInterfaceSetting;

/**
 * Class InterfaceSettings implements the common methods and properties to configure an interface
 *
 * @package kalibao\common\components\crud
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class InterfaceSettings extends Component
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.interface_settings_dependency';

    /**
     * @var int Cache duration
     */
    public $cacheDuration = 86400;

    /**
     * Get settings for an user interface
     * @param int $user User ID
     * @param string $interface Interface ID
     * @return ModelInterfaceSetting
     */
    public function get($user, $interface)
    {
        if ($user !== null) {
            $cacheKey = 'interface_settings:' . $user . '.' . $interface;
            $interfaceSettings = Yii::$app->commonCache->get($cacheKey);

            if ($interfaceSettings === false) {
                $interfaceSettings = ModelInterfaceSetting::findOne([
                    'interface_id' => $interface,
                    'user_id' => $user
                ]);

                if ($interfaceSettings === null) {
                    $interfaceSettings = new ModelInterfaceSetting();
                }

                Yii::$app->commonCache->set(
                    $cacheKey,
                    $interfaceSettings,
                    $this->cacheDuration,
                    new TagDependency([
                        'tags' => [self::getCacheTag($user, $interface)],
                    ])
                );
            }

            return $interfaceSettings;
        } else {
            throw new InvalidParamException('User ID could not be null.');
        }
    }

    /**
     * Returns the cache tag name.
     * @param int $user User ID
     * @param string $interface Interface ID
     * @return string
     */
    protected static function getCacheTag($user, $interface)
    {
        $user = (int) $user;
        $interface = (string) $interface;
        return md5(serialize([self::TAG_DEPENDENCY, $user, $interface]));
    }

    /**
     * Refresh settings for an user interface
     * @param int $user User ID
     * @param string $interface Interface ID
     */
    public function refreshUserInterfaceSettings($user, $interface)
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($user, $interface));
    }
}