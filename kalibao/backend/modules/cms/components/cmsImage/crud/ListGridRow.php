<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\cms\components\cmsImage\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\cms\components\cmsImage\crud
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ListGridRow extends \kalibao\common\components\crud\ListGridRow
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set items
        $this->setItems([
            'cms_image_i18n_title' => isset($this->model->cmsImageI18ns[0]) ? $this->model->cmsImageI18ns[0]->title : '',
            'cms_image_group_i18n_title' => isset($this->model->cmsImageGroupI18ns[0]) ? $this->model->cmsImageGroupI18ns[0]->title : '',
            'file_path' => $this->model->file_path,
        ]);

    }
}