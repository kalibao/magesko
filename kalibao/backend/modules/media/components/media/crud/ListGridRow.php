<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\media\components\media\crud;

use Yii;
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package kalibao\backend\modules\media\components\media\crud
 * @version 1.0
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
            ($this->model->file != '')
                ?
                    $this->fileField($this->model->file)
                :
                    '',
            isset($this->model->mediaTypeI18ns[0]) ? $this->model->mediaTypeI18ns[0]->title : '',
            isset($this->model->mediaI18ns[0]) ? $this->model->mediaI18ns[0]->title : '',
        ]);
    }

    /**
     * creates a correct field depending on the file type :
     * if the file is a picture, it will be displayed
     * if the file is anything else, a link to the resource will be displayed.
     *
     * @param $file string file to put in the row
     * @return string the file field
     */
    public function fileField($file) {
        $filepath = $this->uploadConfig[(new \ReflectionClass($this->model))
                        ->getParentClass()->name]['file']['baseUrl'] . '/' . $this->model->file;
        $text = $file;
        if (in_array(
            strtolower(pathinfo($filepath)['extension']),
            ['jpg', 'png', 'gif', '']))
            $text =  Html::img(
                $filepath,
                [
                    'alt' => isset($this->model->mediaI18ns[0]) ? $this->model->mediaI18ns[0]->title : $file,
                    'height' => '100px',
                    'class' => 'thumbnail center-block'
                ]
            );
        return Html::a(
            $text,
            $filepath,
            [
                'target' => '_blank'
            ]
        );
    }
}