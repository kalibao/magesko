<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE.md
 */

namespace kalibao\console\components\console;

/**
 * This class overload the \yii\console\Application component in order to update coreCommands
 *
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Application extends \yii\console\Application
{
    /**
     * Returns the configuration of the built-in commands.
     * @return array the configuration of the built-in commands.
     */
    public function coreCommands()
    {
        return [
            'help' => 'yii\console\controllers\HelpController',
            'migrate' => 'yii\console\controllers\MigrateController',
            'cache' => 'yii\console\controllers\CacheController',
            'fixture' => 'yii\console\controllers\FixtureController',
        ];
    }
}
