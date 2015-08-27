<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsSimpleMenu\crud;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
use kalibao\common\models\cmsSimpleMenuGroup\CmsSimpleMenuGroupI18n;

/**
 * Class ListGrid
 *
 * @package kalibao\backend\modules\cms\components\cmsSimpleMenu\crud
 * @version 1.0
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGrid extends \kalibao\common\components\crud\ListGrid
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // get model
        $model = $this->getModel();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // set titles
        $this->setTitle(Yii::t('kalibao.backend', 'cms_simple_menu_list_title'));

        // set head attributes
        $this->setGridHeadAttributes([
            'position' => true,
            'cms_simple_menu_i18n_title' => true,
            'cms_simple_menu_i18n_url' => true
        ]);
    }
}