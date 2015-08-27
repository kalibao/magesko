<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\i18n;

use Yii;
use kalibao\common\components\variable\Variable;
use yii\caching\TagDependency;
use yii\i18n\MessageSource;

/**
 * Class DbMessageSource provide a MessageSource component used to translate application.
 * The messages are managed from backend interface.
 *
 * @package kalibao\common\components\i18n
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class DbMessageSource extends MessageSource
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.message_dependency';

    /**
     * @var int Cache duration
     */
    public static $cacheDuration = 86400;

    /**
     * @inheritdoc
     */
    protected function loadMessages($category, $language)
    {
        $cacheKey = 'message_group:'.$category.'.'.$language;
        if (($messages = Yii::$app->commonCache->get($cacheKey)) === false) {
            $rows = (new \yii\db\Query())
                ->select('message.source, message_i18n.translation')
                ->from('message')
                ->innerJoin(
                    'message_i18n',
                    'message.id = message_i18n.message_id AND message_i18n.i18n_id = :language',
                    [':language' => $language]
                )
                ->where(['message.message_group_id' => Yii::$app->variable->get('kalibao', 'message_group_id:'.$category)])
                ->createCommand()
                ->queryAll();

            $messages = [];
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $messages[$row['source']] = $row['translation'];
                }
                Yii::$app->commonCache->set(
                    $cacheKey,
                    $messages,
                    self::$cacheDuration,
                    new TagDependency([
                        'tags' => [self::getCacheTag(), self::getCacheTag($category)],
                    ])
                );
            }
        }

        return $messages;
    }

    /**
     * Return the cache tag name.
     * @param string|null $category Category name
     * @return string
     */
    protected static function getCacheTag($category = null)
    {
        $category = (string) $category;
        return md5(serialize([self::TAG_DEPENDENCY, $category]));
    }

    /**
     * Refresh messages of categories
     */
    public function refreshMessages()
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag());
    }

    /**
     * Refresh messages of category $category
     * @param string $category Category name
     */
    public function refreshMessagesCategory($category)
    {
        $category = (string) $category;
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($category));
    }
}