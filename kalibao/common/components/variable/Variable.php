<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\variable;

use Yii;
use yii\base\Component;
use yii\caching\TagDependency;
use yii\base\InvalidParamException;

/**
 * Class Variable  provide a system to get dynamic variable. The dynamics variables are managed from backend interface.
 * Variables are organized by group.
 *
 * @package kalibao\common\components\variable
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Variable extends Component
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.variable_dependency';

    /**
     * @var int Cache duration
     */
    public $cacheDuration = 86400;

    private $variables = [];

    /**
     * Get value of variable
     *
     * @param string $groupCode Name of group code
     * @param string $name Name of variable
     * @return bool | string
     */
    public function get($groupCode, $name)
    {
        if (isset($this->variables[$groupCode][$name])) {
            return $this->variables[$groupCode][$name];
        } else {
            $variables = $this->findAllByGroup($groupCode);
            if (isset($variables[$name])) {
                return $variables[$name];
            } else {
                throw new InvalidParamException('Variable does not exist in group '.$groupCode.' with param '.$name);
            }
        }
    }

    /**
     * Find all variables by group code
     *
     * @param string $groupCode Name of group code
     * @param bool $allowLocalCaching Allow class caching
     * @return array
     */
    public function findAllByGroup($groupCode, $allowLocalCaching = true)
    {
        if (isset($this->variables[$groupCode]) && $allowLocalCaching) {
            return $this->variables[$groupCode];
        }

        // cache key
        $cacheKey = 'variable_group:'.$groupCode;

        // get from cache
        if (($variables = Yii::$app->commonCache->get($cacheKey)) === false) {
            $rows = (new \yii\db\Query())
                ->select('variable.name, variable.val')
                ->from('variable')
                ->innerJoin(
                    'variable_group',
                    'variable.variable_group_id = variable_group.id AND variable_group.code = :groupCode',
                    [':groupCode' => $groupCode]
                )
                ->createCommand()
                ->queryAll();

            $variables = [];
            if (! empty($rows)) {
                foreach ($rows as $row) {
                    $variables[$row['name']] = $row['val'];
                }

                Yii::$app->commonCache->set(
                    $cacheKey,
                    $variables,
                    $this->cacheDuration,
                    new TagDependency([
                        'tags' => [self::getCacheTag(), self::getCacheTag($groupCode)],
                    ])
                );
            }
        }

        if (! empty($variables)) {
            $this->variables[$groupCode] = $variables;
        }

        return $variables;
    }

    /**
     * Return the cache tag name.
     * @param string|null $groupCode Group code
     * @return string
     */
    protected static function getCacheTag($groupCode = null)
    {
        $groupCode = (string) $groupCode;
        return md5(serialize([self::TAG_DEPENDENCY, $groupCode]));
    }

    /**
     * Refresh variables of groups
     */
    public function refreshVariables()
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag());
    }

    /**
     * Refresh variables of group
     * @param string $groupCode Group code
     */
    public function refreshVariablesGroup($groupCode)
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($groupCode));
    }
}
