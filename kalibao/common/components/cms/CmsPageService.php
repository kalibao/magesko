<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\cms;

use Yii;
use yii\base\Object;
use yii\caching\TagDependency;
use kalibao\common\models\cmsPage\CmsPage as CmsPageModel;

/**
 * Class CmsPageService provide a system to manage cms pages
 *
 * @package kalibao\common\components\cms
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class CmsPageService extends Object
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.cms_page';

    /**
     * @var int Cache duration
     */
    public $cacheDuration = 86400;

    /**
     * Get slug by ID
     * @param int $id Cms page ID
     * @param string $language Language ID
     * @return bool
     */
    public static function getSlugById($id, $language)
    {
        // cache key
        $cacheKey = 'cms_page_id:' . $id . ':' . $language;

        // get from cache
        if (($slug = Yii::$app->commonCache->get($cacheKey)) === false) {
            $cmsPage = CmsPageModel::find()
                ->select(['id', 'cache_duration'])
                ->innerJoinWith([
                    'cmsPageI18ns' => function ($query) use ($language) {
                        $query
                            ->select(['cms_page_id', 'slug'])
                            ->where([
                                'i18n_id' => $language,
                            ]);
                    },
                ])
                ->where(['id' => $id, 'activated' => 1])
                ->asArray()
                ->one();

            if ($cmsPage !== null && isset($cmsPage['cmsPageI18ns'][0])) {
                $slug = $cmsPage['cmsPageI18ns'][0]['slug'];

                // set in cache
                Yii::$app->commonCache->set(
                    $cacheKey,
                    $slug,
                    $cmsPage['cache_duration'],
                    new TagDependency([
                        'tags' => [
                            self::getCacheTag(),
                            self::getCacheTag($cmsPage['id']),
                            self::getCacheTag(
                                $cmsPage['id'],
                                $cmsPage['cmsPageI18ns'][0]['slug'],
                                Yii::$app->language
                            ),
                        ],
                    ])
                );
            } else {
                return false;
            }
        }
        return $slug;
    }

    /**
     * Return the cache tag name.
     * @param int $id Page ID
     * @param string|null $slug Slug
     * @param string|null $language Language ID
     * @return string
     */
    public static function getCacheTag($id = null, $slug = null, $language = null)
    {
        $id = (int) $id;
        $slug = (string) $slug;
        $language = (string) $language;
        return md5(serialize([self::TAG_DEPENDENCY, $id, $slug, $language]));
    }

    /**
     * Refresh cms pages
     */
    public function refreshPages()
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag());
    }

    /**
     * Refresh cms page
     * @param int $id Page ID
     * @param string $slug Slug
     * @param string $language Language ID
     */
    public function refreshPage($id, $slug, $language)
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($id, $slug, $language));
    }
}
