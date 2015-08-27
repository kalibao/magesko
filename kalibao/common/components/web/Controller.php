<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\web;

use Yii;
use kalibao\common\components\i18n\ApplicationLanguage;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Controller overload default controller component in order to add features
 *  - getter to access to the role of controller actions
 *  - process to change current language
 *  - uploader methods definitions
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Controller extends \yii\web\Controller
{
    /**
     * Upload configuration
     *
     * ex:
     * [
     *   'modelName' => [
     *     'attributeName' => [
     *       'basePath' => '',
     *       'baseUrl' => ''
     *     ],
     *     '...' => [
     *       'basePath' => '',
     *       'baseUrl' => ''
     *     ]
     *   ],
     *   'modelName2' => [
     *     ...
     *   ]
     * ]
     *
     * @var array
     */
    protected $uploadConfig = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->processLanguage();
        if (! Yii::$app->request->isAjax) {
            $this->registerClientSide();
        }
    }

    /**
     * Get permission of controller action
     * @param string $action Action name
     * @param null|string $controller Controller path
     * @return string
     */
    public static function getActionControllerPermission($action, $controller = null)
    {
        if ($controller === null) {
            $controller = static::className();
        }

        return 'permission.'.$action.':'.$controller;
    }

    /**
     * Register client side
     */
    protected function registerClientSide()
    {
        ApplicationLanguage::registerClientSideLanguage($this->getView());
        ApplicationLanguage::registerClientSideDefaultMessages($this->getView());
        ApplicationLanguage::registerClientSideDatePickerLanguage($this->getView());
    }

    /**
     * Register client side script on ajax request
     */
    protected function registerClientSideAjaxScript()
    {
        return [];
    }

    /**
     * Process language
     */
    protected function processLanguage()
    {
        $request = Yii::$app->request;
        $appLanguage = Yii::$app->appLanguage;

        $language = null;
        if (($tmpLanguage = $request->post('language')) !== null) { // change language of current interface
            $language = $appLanguage->secureLanguage($tmpLanguage);
            // redirect
            $this->redirect($request->post($language))->send();
            Yii::$app->end();
        } elseif (($tmpLanguage = $request->get('language')) !== null) { // get language from request
            $language = $appLanguage->secureLanguage($tmpLanguage);
        } else { // if no language found
            if (($tmpLanguage = $appLanguage->getSessionLanguage()) !== null) { // get language from session
                $language = $appLanguage->secureLanguage($tmpLanguage);
            } elseif (($tmpLanguage = $request->cookies->get('language')) !== null) { // get language from cookie
                $language = $appLanguage->secureLanguage($tmpLanguage->value);
            } else { // get browser language
                $language = $appLanguage->secureLanguage($appLanguage->getBrowserLanguage());
            }
        }
        $appLanguage->setLanguage($language);
    }

    /**
     * Update uploaded file name
     * @param ActiveRecord $model Model
     * @param string $attributeName Attribute name
     * @param UploadedFile|null $uploadedFile UploadedFile instance
     * @throws NotSupportedException
     */
    protected function updateUploadedFileName(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        throw new NotSupportedException();
    }

    /**
     * Remove uploaded file
     * @param ActiveRecord $model Model
     * @param string $attributeName Attribute name
     * @throws NotSupportedException
     */
    protected function removeUploadedFile(ActiveRecord $model, $attributeName)
    {
        throw new NotSupportedException();
    }

    /**
     * Remove old uploaded file
     * @param ActiveRecord $model Model
     * @param string $attributeName Attribute name
     * @param string $fileName File name
     * @throws NotSupportedException
     */
    protected function removeOldUploadedFile(ActiveRecord $model, $attributeName, $fileName)
    {
        throw new NotSupportedException();
    }

    /**
     * Save uploaded file
     * @param ActiveRecord $model Model
     * @param string $attributeName Attribute name
     * @param UploadedFile|null $uploadedFile UploadedFile instance
     * @throws NotSupportedException
     */
    protected function saveUploadedFile(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        throw new NotSupportedException();
    }

    /**
     * Get an array used to fill
     * @param string $id drop down ID
     * @return array
     * @throws NotSupportedException
     */
    protected function getDropDownList($id)
    {
        throw new NotSupportedException();
    }

    /**
     * Get an array used to fill
     * @param string $id drop down ID
     * @return array
     * @throws NotSupportedException
     */
    protected function getImageDropDown($id)
    {
        throw new NotSupportedException();
    }

    /**
     * Get parameters used from $this->actionAdvancedDropDown()
     * @param string $id drop down ID
     * @param string $search Search value
     * @return array [['id' => '', 'text' => ''], ...]
     * @throws NotSupportedException
     */
    protected function getAdvancedDropDownList($id, $search)
    {
        throw new NotSupportedException();
    }
}
