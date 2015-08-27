<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\components\web;

use kalibao\common\components\i18n\I18N;
use Yii;
use kalibao\common\components\helpers\Html;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class LanguageMenuWidget provides a widget to switch current language
 * @package kalibao\backend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class LanguageMenuWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        // get app language of current application
        $languages = Yii::$app->appLanguage->getAppLanguages();
        $languageLabels = [];
        foreach ($languages as $languageId) {
            $languageLabels[$languageId] = I18N::label($languageId);
        }

        // build form
        $html = '<form method="post" class="current-language" action="' . Yii::$app->request->url . '">';
        $html .= Html::dropDownList(
            'language', Yii::$app->language, $languageLabels, ['class' => 'language-selector form-control']
        );
        foreach ($languages as $languageId) {
            $html .= Html::hiddenInput(
                $languageId,
                Url::to([''] + array_merge(Yii::$app->request->get(), ['language' => $languageId]))
            );
        }
        $html .= '</form>';

        return $html;
    }
}