<?php
/**
 * @copyright Copyright (c) 2016 - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\web;


class JuiAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui/';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];

    public $js = [
        'ui/minified/core.min.js',
        'ui/minified/widget.min.js',
        'ui/minified/mouse.min.js',
        'ui/minified/sortable.min.js',
//        'ui/minified/accordion.min.js',
//        'ui/minified/autocomplete.min.js',
//        'ui/minified/button.min.js',
//        'ui/minified/datepicker.min.js',
//        'ui/minified/dialog.min.js',
//        'ui/minified/draggable.min.js',
//        'ui/minified/droppable.min.js',
//        'ui/minified/effect-blind.min.js',
//        'ui/minified/effect-bounce.min.js',
//        'ui/minified/effect-clip.min.js',
//        'ui/minified/effect-drop.min.js',
//        'ui/minified/effect-explode.min.js',
//        'ui/minified/effect-fade.min.js',
//        'ui/minified/effect-fold.min.js',
//        'ui/minified/effect-highlight.min.js',
//        'ui/minified/effect.min.js',
//        'ui/minified/effect-puff.min.js',
//        'ui/minified/effect-pulsate.min.js',
//        'ui/minified/effect-scale.min.js',
//        'ui/minified/effect-shake.min.js',
//        'ui/minified/effect-size.min.js',
//        'ui/minified/effect-slide.min.js',
//        'ui/minified/effect-transfer.min.js',
//        'ui/minified/menu.min.js',
//        'ui/minified/position.min.js',
//        'ui/minified/progressbar.min.js',
//        'ui/minified/resizable.min.js',
//        'ui/minified/selectable.min.js',
//        'ui/minified/selectmenu.min.js',
//        'ui/minified/slider.min.js',
//        'ui/minified/spinner.min.js',
//        'ui/minified/tabs.min.js',
//        'ui/minified/tooltip.min.js',
    ];
    public $css = [
        'themes/smoothness/jquery-ui.css',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}