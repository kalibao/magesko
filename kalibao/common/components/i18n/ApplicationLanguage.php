<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\i18n;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\TagDependency;
use yii\jui\DatePickerLanguageAsset;
use yii\jui\JuiAsset;
use yii\web\Cookie;
use kalibao\common\components\variable\Variable;
use kalibao\common\models\language\Language;
use kalibao\common\models\languageGroupLanguage\LanguageGroupLanguage;
use kalibao\backend\components\web\LanguageMenuWidget;

/**
 * Class ApplicationLanguage provide a component that provide method to manage language in an application.
 *
 * @package kalibao\common\components\i18n
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class ApplicationLanguage extends Component
{
    /**
     * Tag dependency
     */
    const TAG_DEPENDENCY = 'kalibao.common.app_language_dependency';

    /**
     * @var int Cache duration
     */
    public $cacheDuration = 86400;

    /**
     * @var string parameter of language session
     */
    public $sessionLanguageParam = 'language';

    /**
     * @var string name of language group
     */
    public $languageGroupName;

    private $validLanguages = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->languageGroupName)) {
            throw new InvalidConfigException('The language group name is not defined');
        }
    }

    /**
     * Get browser language
     */
    public function getBrowserLanguage()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        } else {
            return Yii::$app->sourceLanguage;
        }
    }

    /**
     * Secure language ID
     * @param string $language language ID
     * @return string return a language ID
     */
    public function secureLanguage($language)
    {
        return self::isValidLanguage($language) ? $language : Yii::$app->language;
    }

    /**
     * Verify if the language ID is valid
     * @param $language language ID
     * @return bool
     * @throws InvalidConfigException
     */
    public function isValidLanguage($language)
    {
        return in_array($language, $this->getAppLanguages());
    }

    /**
     * Get application languages
     * @return string[] application languages
     * @throws InvalidConfigException
     */
    public function getAppLanguages()
    {
        if (empty($this->validLanguages)) {
            $cacheKey = 'language_group:'.$this->languageGroupName;
            if (($languages = Yii::$app->commonCache->get($cacheKey)) === false) {
                $languages = LanguageGroupLanguage::find()
                    ->select('language_id')
                    ->where([
                        'activated' => true,
                        'language_group_id' => Yii::$app->variable->get('kalibao', 'language_group_id:'.$this->languageGroupName)
                    ])
                    ->all();

                if (!empty($languages)) {
                    foreach($languages as $language) {
                        $this->validLanguages[] = $language->language_id;
                    }
                    Yii::$app->commonCache->set(
                        $cacheKey,
                        $this->validLanguages,
                        $this->cacheDuration,
                        new TagDependency([
                            'tags' => [self::getCacheTag(), self::getCacheTag($this->languageGroupName)],
                        ])
                    );
                } else {
                    throw new InvalidConfigException("The language group name does not exist: {$this->languageGroupName}");
                }
            } else {
                $this->validLanguages = $languages;
            }
        }

        return $this->validLanguages;
    }

    /**
     * Reorder languages and set $priorityLanguage at start
     * @param array $languages Languages to reorder
     * @param string $priorityLanguage Language to move
     * @return array
     */
    public static function reorderLanguages($languages, $priorityLanguage)
    {
        $key = array_search($priorityLanguage, $languages);
        if ($key !== false) {
            $tmpLanguages = [$languages[$key]];
            unset($languages[$key]);
            foreach ($languages as $language) {
                $tmpLanguages[] = $language;
            }
            $languages = $tmpLanguages;
            unset($tmpLanguages);
        }
        return $languages;
    }

    /**
     * Set language
     * @param string $language language ID
     * @param bool $secure verify the language ID and correct it if needed
     */
    public function setLanguage($language, $secure = true)
    {
        $language = $secure ? $this->secureLanguage($language) : $language;
        $this->setCookieLanguage($language, false);
        $this->setAppLanguage($language, false);
        $this->setSessionLanguage($language, false);
    }

    /**
     * Set cookie language
     * @param string $language language ID
     * @param bool $secure verify the language ID and correct it if needed
     */
    public function setCookieLanguage($language, $secure = true)
    {
        $language = $secure ? $this->secureLanguage($language) : $language;
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'language',
            'value' => $language,
            'expire' => time() + (60 * 60 * 24 * 365) // (1 year)
        ]));
    }

    /**
     * Set application language
     * @param string $language language ID
     * @param bool $secure verify the language ID and correct it if needed
     */
    public function setAppLanguage($language, $secure = true)
    {
        $language = $secure ? $this->secureLanguage($language) : $language;
        Yii::$app->language = $language;
    }

    /**
     * Set session language
     * @param string $language language ID
     * @param bool $secure verify the language ID and correct it if needed
     */
    public function setSessionLanguage($language, $secure = true)
    {
        $language = $secure ? $this->secureLanguage($language) : $language;
        Yii::$app->session->set($this->sessionLanguageParam, $language);
    }

    /**
     * Get session language
     */
    public function getSessionLanguage()
    {
        return Yii::$app->session->get($this->sessionLanguageParam);
    }

    /**
     * Get the cache tag name.
     * @param string|null $languageGroupCode Language group code
     * @return string
     */
    protected static function getCacheTag($languageGroupCode = null)
    {
        return md5(serialize([self::TAG_DEPENDENCY, $languageGroupCode]));
    }

    /**
     * Refresh languages of groups
     */
    public static function refreshLanguages()
    {
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag());
    }

    /**
     * Refresh languages of group $languageGroupCode
     * @param string $languageGroupCode Language group code
     */
    public static function refreshLanguagesGroup($languageGroupCode)
    {
        $languageGroupCode = (string) $languageGroupCode;
        TagDependency::invalidate(Yii::$app->commonCache, self::getCacheTag($languageGroupCode));
    }

    /**
     * Register language on client side
     * @param \yii\web\View $view View context
     */
    public static function registerClientSideLanguage($view)
    {
        $view->registerJs('$.kalibao.core.app.language = "'.Yii::$app->language.'";');
    }

    /**
     * Register default messages on client side
     * @param \yii\web\View $view View context
     */
    public static function registerClientSideDefaultMessages($view)
    {
        $messages = [
            'kalibao' => [
                'modal_remove_one' => Yii::t('kalibao', 'modal_remove_one'),
                'modal_remove_selected' => Yii::t('kalibao', 'modal_remove_selected'),
                'modal_remove_one' => Yii::t('kalibao', 'modal_remove_one'),
                'btn_confirm' => Yii::t('kalibao', 'btn_confirm'),
                'btn_cancel' => Yii::t('kalibao', 'btn_cancel'),
                'btn_delete' => Yii::t('kalibao', 'btn_delete'),
                'select_input_add' => Yii::t('kalibao', 'select_input_add'),
                'select_input_update' => Yii::t('kalibao', 'select_input_update'),
                'browser_compatibility_error_ie10' => Yii::t('kalibao', 'browser_compatibility_error_ie10'),
            ]
        ];
        $view->registerJs('$.kalibao.core.app.messages = '.json_encode($messages).';');
    }

    /**
     * Register date picker language on client side
     * @param \yii\web\View $view View context
     */
    public static function registerClientSideDatePickerLanguage($view)
    {
        $language = Yii::$app->language;

        if ($language != 'en-US' && $language != 'en') {
            $bundle = DatePickerLanguageAsset::register($view);
            if ($bundle->autoGenerate) {
                $fallbackLanguage = substr($language, 0, 2);
                if ($fallbackLanguage !== $language && !file_exists(Yii::getAlias($bundle->sourcePath . "/ui/i18n/datepicker-$language.js"))) {
                    $language = $fallbackLanguage;
                }
                $view->registerJsFile($bundle->baseUrl . "/ui/i18n/datepicker-$language.js", [
                    'depends' => [JuiAsset::className()],
                ]);
                $view->registerJs("$.kalibao.core.app.datePickerLanguage = $.datepicker.regional['{$language}'];");
            }
        }
    }
}