<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\base;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\FileHelper;

/**
 * Class View overload the default view class in order to add features :
 *  - renderFile method is modified in order to include default view files if view files don't exist in current folder.
 *
 * @package kalibao\common\components\base
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class View extends \yii\web\View
{
    /**
     * @var array the view files currently being rendered. There may be multiple view files being
     * rendered at a moment because one view may be rendered within another.
     */
    private $viewFiles = [];

    /**
     * Renders a view file.
     *
     * If [[theme]] is enabled (not null), it will try to render the themed version of the view file as long
     * as it is available.
     *
     * The method will call [[FileHelper::localize()]] to localize the view file.
     *
     * If [[renderers|renderer]] is enabled (not null), the method will use it to render the view file.
     * Otherwise, it will simply include the view file as a normal PHP file, capture its output and
     * return it as a string.
     *
     * @param string $viewFile the view file. This can be either an absolute file path or an alias of it.
     * @param array $params the parameters (name-value pairs) that will be extracted and made available in the view file.
     * @param object $context the context that the view should use for rendering the view. If null,
     * existing [[context]] will be used.
     * @return string the rendering result
     * @throws InvalidParamException if the view file does not exist
     */
    public function renderFile($viewFile, $params = [], $context = null)
    {
        $viewFile = Yii::getAlias($viewFile);

        if ($this->theme !== null) {
            $viewFile = $this->theme->applyTo($viewFile);
        }

        if (is_file($viewFile)) {
            $viewFile = FileHelper::localize($viewFile);
        } else {
            if (strpos($viewFile, $context->getViewPath()) === 0) {
                $viewFile = Yii::getAlias('@kalibao/views') . substr($viewFile, strlen($context->getViewPath()), strlen($viewFile));
            }
            if (!is_file($viewFile)) {
                throw new InvalidParamException("The view file does not exist: $viewFile");
            }
        }

        $oldContext = $this->context;
        if ($context !== null) {
            $this->context = $context;
        }
        $output = '';
        $this->viewFiles[] = $viewFile;

        if ($this->beforeRender($viewFile, $params)) {
            Yii::trace("Rendering view file: $viewFile", __METHOD__);
            $ext = pathinfo($viewFile, PATHINFO_EXTENSION);
            if (isset($this->renderers[$ext])) {
                if (is_array($this->renderers[$ext]) || is_string($this->renderers[$ext])) {
                    $this->renderers[$ext] = Yii::createObject($this->renderers[$ext]);
                }
                /* @var $renderer ViewRenderer */
                $renderer = $this->renderers[$ext];
                $output = $renderer->render($this, $viewFile, $params);
            } else {
                $output = $this->renderPhpFile($viewFile, $params);
            }
            $this->afterRender($viewFile, $params, $output);
        }

        array_pop($this->viewFiles);
        $this->context = $oldContext;

        return $output;
    }

    /**
     * @return string|boolean the view file currently being rendered. False if no view file is being rendered.
     */
    public function getViewFile()
    {
        return end($this->viewFiles);
    }
}