<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
namespace kalibao\console\controllers;

use yii;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Allows you to combine and compress your JavaScript and CSS files
 *
 * @author Kevin Walter <walkev13@gmail.com>
 */
class AssetsCompressorController extends Controller
{
    /**
     * @var string controller default action ID.
     */
    public $defaultAction = 'compress';

    /**
     * @var string|callable JavaScript file compressor.
     * If a string, it is treated as shell command template, which should contain
     * placeholders {from} - source file name - and {to} - output file name.
     * Otherwise, it is treated as PHP callback, which should perform the compression.
     *
     * Default value relies on usage of "Closure Compiler"
     * @see https://developers.google.com/closure/compiler/
     */
    public $jsCompressor = 'java -jar kalibao/compiler/compiler.jar --js {from} --js_output_file {to}';

    /**
     * @var string|callable CSS file compressor.
     * If a string, it is treated as shell command template, which should contain
     * placeholders {from} - source file name - and {to} - output file name.
     * Otherwise, it is treated as PHP callback, which should perform the compression.
     *
     * Default value relies on usage of "YUI Compressor"
     * @see https://github.com/yui/yuicompressor/
     */
    public $cssCompressor = 'java -jar kalibao/compiler/yuicompressor.jar --type css {from} -o {to}';

    /**
     * @var array|\yii\web\AssetManager [[\yii\web\AssetManager]] instance or its array configuration, which will be used
     * for assets processing.
     */
    private $_assetManager = [];

    /**
     * @var array
     * Configuration array used to build assets packages
     */
    public $groupsAssets;

    /**
     * Combines and compresses the asset files according to the given configuration.
     * @param string $configFile configuration file name.
     */
    public function actionCompress($configFile)
    {
        // load configuration
        $this->loadConfiguration($configFile);

        // get list of bundles
        $bundles = $this->loadBundles($this->refactorGroupsAssetsToSimpleList());

        // refactor groups assets in order to integrate dependencies
        foreach ($this->groupsAssets as &$group) {
            foreach($group['assets'] as $asset => $recursive) {
                if (isset($bundles[$asset]->depends) && $recursive === true) {
                   $this->findDepends($bundles[$asset]->depends, $bundles, $group);
                }
                if (isset($bundles[$asset])) {
                    $group['baseUrl'] = isset($bundles[$asset]->baseUrl) ? $bundles[$asset]->baseUrl : null;
                    $group['basePath'] = isset($bundles[$asset]->basePath) ? $bundles[$asset]->basePath : null;
                    $group['js'] = isset($bundles[$asset]->js) ? $bundles[$asset]->js : null;
                    $group['css'] = isset($bundles[$asset]->css) ? $bundles[$asset]->css : null;
                }
            }
        }
        unset($group);

        // generate final groups assets configuration file
        $refactorGroups = [];
        foreach ($this->groupsAssets as $key => $group) {
            $refactorGroups[$key] = [];

            if (isset($group['depends'])) {
                foreach ($group['depends'] as $g) {
                    foreach ($g['js'] as $js) {
                        $refactorGroups[$key]['js'][] = array(
                            'path' => $g['basePath'] . '/' . $js,
                            'url' => $g['baseUrl'] . '/' . $js,
                        );
                    }
                    foreach ($g['css'] as $css) {
                        $refactorGroups[$key]['css'][] = array(
                            'path' => $g['basePath'] . '/' . $css,
                            'url' => $g['baseUrl'] . '/' . $css,
                        );
                    }
                }
            }
            foreach($group['js'] as $js) {
                $refactorGroups[$key]['js'][] = array(
                    'path' => $group['basePath'].'/'.$js,
                    'url' => $group['baseUrl'].'/'.$js,
                );
            }
            foreach($group['css'] as $css) {
                $refactorGroups[$key]['css'][] = array(
                    'path' => $group['basePath'].'/'.$css,
                    'url' => $group['baseUrl'].'/'.$css,
                );
            }

            $refactorGroups[$key]['outputFile'] = $group['outputFile'];
            $refactorGroups[$key]['outputBasePath'] = Yii::getAlias($group['outputBasePath']);
        }

        // save groups
        $this->saveTargets($refactorGroups);
    }

    /*
     * Refactor groups assets configuration to simple list
     */
    protected function refactorGroupsAssetsToSimpleList()
    {
        foreach ($this->groupsAssets as $group) {
            foreach($group['assets'] as $asset => $recursive) {
                $groupsAssetsFlat[] = $asset;
            }
        }

        return $groupsAssetsFlat;
    }

    /**
     * Find dependencies recursively
     * @param \yii\web\AssetBundle[] $depends List of source asset bundles which contain dependencies
     * @param \yii\web\AssetBundle[] $bundles List of source asset bundles
     * @param array $group Current group of asset bundles
     */
    protected function findDepends($depends, &$bundles, &$group)
    {
        foreach($depends as $depend) {
            $bundle = $bundles[$depend];
            if (isset($bundle->depends)) {
                $this->findDepends($bundle->depends, $bundles, $group);
            }
            $group['depends'][$depend] = [
                'baseUrl' => isset($bundle->baseUrl) ? $bundle->baseUrl : null,
                'basePath' => isset($bundle->basePath) ? $bundle->basePath : null,
                'js' => isset($bundle->js) ? $bundle->js : null,
                'css' => isset($bundle->css) ? $bundle->css : null,
            ];
        }
    }

    /**
     * Saves new asset bundles configuration.
     * @param mixed $refactorGroups list of asset bundles to be saved.
     * @throws \yii\console\Exception on failure.
     */
    protected function saveTargets($refactorGroups)
    {
        foreach($refactorGroups as $key => $group) {
            if (isset($group['js'])) {
                // path file
                $pathFile = $group['outputBasePath'].'/js/'.$refactorGroups[$key]['outputFile'].'.js';
                // temp file
                $tempFile = strtr($pathFile, ['{hash}' => 'temp']);
                // compress js files
                $this->compressJsFiles($group['js'], $tempFile);
                // final output file
                $outputFile = strtr($pathFile, ['{hash}' => md5_file($tempFile)]);
                rename($tempFile, $outputFile);
            }
            if (isset($group['css'])) {
                // path file
                $pathFile = $group['outputBasePath'].'/css/'.$refactorGroups[$key]['outputFile'].'.css';
                // temp file
                $tempFile = strtr($pathFile, ['{hash}' => 'temp']);
                // compress js files
                $this->compressCssFiles($group['css'], $tempFile);
                // final output file
                $outputFile = strtr($pathFile, ['{hash}' => md5_file($tempFile)]);
                rename($tempFile, $outputFile);
            }
        }
    }

    /**
     * Applies configuration from the given file to self instance.
     * @param string $configFile configuration file name.
     * @throws \yii\console\Exception on failure.
     */
    protected function loadConfiguration($configFile)
    {
        $this->stdout("Loading configuration from '{$configFile}'...\n");
        foreach (require($configFile) as $name => $value) {
            if (property_exists($this, $name) || $this->canSetProperty($name)) {
                $this->$name = $value;
            } else {
                throw new Exception("Unknown configuration option: $name");
            }
        }

        $this->getAssetManager(); // check if asset manager configuration is correct
    }


    /**
     * Returns the asset manager instance.
     * @throws \yii\console\Exception on invalid configuration.
     * @return \yii\web\AssetManager asset manager instance.
     */
    public function getAssetManager()
    {
        if (!is_object($this->_assetManager)) {
            $options = $this->_assetManager;
            if (!isset($options['class'])) {
                $options['class'] = 'yii\\web\\AssetManager';
            }
            if (!isset($options['basePath'])) {
                throw new Exception("Please specify 'basePath' for the 'assetManager' option.");
            }
            if (!isset($options['baseUrl'])) {
                throw new Exception("Please specify 'baseUrl' for the 'assetManager' option.");
            }
            $this->_assetManager = Yii::createObject($options);
        }

        return $this->_assetManager;
    }

    /**
     * Sets asset manager instance or configuration.
     * @param \yii\web\AssetManager|array $assetManager asset manager instance or its array configuration.
     * @throws \yii\console\Exception on invalid argument type.
     */
    public function setAssetManager($assetManager)
    {
        if (is_scalar($assetManager)) {
            throw new Exception('"' . get_class($this) . '::assetManager" should be either object or array - "' . gettype($assetManager) . '" given.');
        }
        $this->_assetManager = $assetManager;
    }

    /**
     * Creates full list of source asset bundles.
     * @param string[] $bundles list of asset bundle names
     * @return \yii\web\AssetBundle[] list of source asset bundles.
     */
    protected function loadBundles($bundles)
    {
        $this->stdout("Collecting source bundles information...\n");

        $am = $this->getAssetManager();
        $result = [];
        foreach ($bundles as $name) {
            $result[$name] = $am->getBundle($name);
        }
        foreach ($result as $bundle) {
            $this->loadDependency($bundle, $result);
        }

        return $result;
    }

    /**
     * Loads asset bundle dependencies recursively.
     * @param \yii\web\AssetBundle $bundle bundle instance
     * @param array $result already loaded bundles list.
     * @throws Exception on failure.
     */
    protected function loadDependency($bundle, &$result)
    {
        $am = $this->getAssetManager();
        foreach ($bundle->depends as $name) {
            if (!isset($result[$name])) {
                $dependencyBundle = $am->getBundle($name);
                $result[$name] = false;
                $this->loadDependency($dependencyBundle, $result);
                $result[$name] = $dependencyBundle;
            } elseif ($result[$name] === false) {
                throw new Exception("A circular dependency is detected for bundle '$name'.");
            }
        }
    }
    /**
     * Compresses given JavaScript files and combines them into the single one.
     * @param array $inputFiles list of source file names.
     * @param string $outputFile output file name.
     * @throws \yii\console\Exception on failure
     */
    protected function compressJsFiles($inputFiles, $outputFile)
    {
        if (empty($inputFiles)) {
            return;
        }
        $this->stdout("  Compressing JavaScript files...\n");
        if (is_string($this->jsCompressor)) {
            $tmpFile = $outputFile . '.tmp';
            $this->combineJsFiles($inputFiles, $tmpFile);
            $this->stdout(shell_exec(strtr($this->jsCompressor, [
                '{from}' => escapeshellarg($tmpFile),
                '{to}' => escapeshellarg($outputFile),
            ])));
            @unlink($tmpFile);
        } else {
            call_user_func($this->jsCompressor, $this, $inputFiles, $outputFile);
        }
        if (!file_exists($outputFile)) {
            throw new Exception("Unable to compress JavaScript files into '{$outputFile}'.");
        }
        $this->stdout("  JavaScript files compressed into '{$outputFile}'.\n");
    }

    /**
     * Compresses given CSS files and combines them into the single one.
     * @param array $inputFiles list of source file names.
     * @param string $outputFile output file name.
     * @throws \yii\console\Exception on failure
     */
    protected function compressCssFiles($inputFiles, $outputFile)
    {
        if (empty($inputFiles)) {
            return;
        }
        $this->stdout("  Compressing CSS files...\n");
        if (is_string($this->cssCompressor)) {
            $tmpFile = $outputFile . '.tmp';
            $this->combineCssFiles($inputFiles, $tmpFile);
            $this->stdout(shell_exec(strtr($this->cssCompressor, [
                '{from}' => escapeshellarg($tmpFile),
                '{to}' => escapeshellarg($outputFile),
            ])));
            @unlink($tmpFile);
        } else {
            call_user_func($this->cssCompressor, $this, $inputFiles, $outputFile);
        }
        if (!file_exists($outputFile)) {
            throw new Exception("Unable to compress CSS files into '{$outputFile}'.");
        }
        $this->stdout("  CSS files compressed into '{$outputFile}'.\n");
    }

    /**
     * Combines JavaScript files into a single one.
     * @param array $inputFiles source file names.
     * @param string $outputFile output file name.
     * @throws \yii\console\Exception on failure.
     */
    public function combineJsFiles($inputFiles, $outputFile)
    {
        $content = '';
        foreach ($inputFiles as $file) {
            $content .= "/*** BEGIN FILE: ".$file['path']." ***/\n"
                . file_get_contents($file['path'])
                . "/*** END FILE: ".$file['path']." ***/\n";
        }
        if (!file_put_contents($outputFile, $content)) {
            throw new Exception("Unable to write output JavaScript file '{$outputFile}'.");
        }
    }

    /**
     * Combines CSS files into a single one.
     *
     * @param array $inputFiles source file names.
     * @param string $outputFile output file name without suffix.
     * @throws \yii\console\Exception on failure.
     */
    public function combineCssFiles($inputFiles, $outputFile)
    {
        $content = '';
        foreach ($inputFiles as $file) {
            $infoFileUrl = pathinfo($file['url']);
            $buffer = file_get_contents($file['path']);

            $matchFind = array();
            preg_match_all('#url\("{0,1}\'{0,1}([^"\')]*)"{0,1}\'{0,1}\)#', $buffer, $matchFind);
            $matchFind[1] = array_unique($matchFind[1]);
            foreach ($matchFind[1] as $result) {
                $imageInfo = pathinfo($result);
                if (mb_substr($imageInfo['dirname'], 0, 1) != '/') {
                   $buffer = str_replace($result,  $infoFileUrl['dirname'].'/'.$result, $buffer);
                }
            }
            $content .= $buffer;
        }

        if (!file_put_contents($outputFile, $content)) {
            throw new Exception("Unable to write output JavaScript file '{$outputFile}'.");
        }
    }
}