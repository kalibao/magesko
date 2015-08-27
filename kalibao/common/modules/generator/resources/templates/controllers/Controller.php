<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

echo "<?php\n";
?>
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace <?= $namespace ?>;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use kalibao\common\components\helpers\Html;
use kalibao\<?= $generator->application ?>\components\crud\Controller;

/**
 * Class <?= $generator->controller ?>Controller
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
 */
class <?= $generator->controller ?>Controller extends Controller
{
    /**
     * @inheritdoc
     */
    protected $crudModelsClass = [
        'main' => 'kalibao\common\models\<?= lcfirst($generator->controller) ?>\<?= $generator->controller ?>',
<?php if($languageExist): ?>
        'i18n' => 'kalibao\common\models\<?= lcfirst($generator->controller) ?>\<?= $generator->controller ?>I18n',
<?php endif; ?>
        'filter' => '<?= $baseNamespaces ?>\models\<?= lcfirst($generator->controller) ?>\crud\ModelFilter',
    ];

    /**
     * @inheritdoc
     */
    protected $crudComponentsClass = [
        'edit' => '<?= $baseNamespaces ?>\components\<?= lcfirst($generator->controller) ?>\crud\Edit',
        'list' => '<?= $baseNamespaces ?>\components\<?= lcfirst($generator->controller) ?>\crud\ListGrid',
        'listFields' => '<?= $baseNamespaces ?>\components\<?= lcfirst($generator->controller) ?>\crud\ListGridRow',
        'listFieldsEdit' => '<?= $baseNamespaces ?>\components\<?= lcfirst($generator->controller) ?>\crud\ListGridRowEdit',
        'exportCsv' => '<?= $baseNamespaces ?>\components\<?= lcfirst($generator->controller) ?>\crud\ExportCsv',
        'translate' => '<?= $baseNamespaces ?>\components\<?= lcfirst($generator->controller) ?>\crud\Translate',
        'setting' => '<?= $baseNamespaces ?>\components\<?= lcfirst($generator->controller) ?>\crud\Setting',
    ];

    private $dropDownLists = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set upload config
        $this->uploadConfig = [
            $this->crudModelsClass['main'] => [<?php foreach ($fileColumns as $column): ?>

                '<?= $column[1]->name ?>' => [
                    'basePath' => Yii::getAlias('@kalibao/data'),
                    'baseUrl' => Yii::$app->cdnManager->getBaseUrl() . '/common/data',
                    'type' => '<?= $column[0] == $generator::TYPE_IMAGE_INPUT ? 'image' : 'file' ?>'
                ],<?php endforeach; ?>

            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function updateUploadedFileName(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {<?php foreach ($fileColumns as $column): ?>

            case $this->crudModelsClass['main'] . '.<?= $column[1]->name ?>':
                $uploadedFile->name = md5(Yii::$app->getSecurity()->generateRandomString() . '.' . uniqid())
                    . '.' . $model->$attributeName->extension;
                break;<?php endforeach; ?>

            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function saveUploadedFile(ActiveRecord $model, $attributeName, $uploadedFile)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {<?php foreach ($fileColumns as $column): ?>

            case $this->crudModelsClass['main'] . '.<?= $column[1]->name ?>':
                if (!$uploadedFile->saveAs(
                    $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath']
                    . '/' . $uploadedFile->name
                )) {
                    throw new ErrorException('Impossible to save file.');
                }
                break;<?php endforeach; ?>

            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function removeOldUploadedFile(ActiveRecord $model, $attributeName, $fileName)
    {
        $id = (new \ReflectionClass($model))->getName() . '.' . $attributeName;
        switch ($id) {<?php foreach ($fileColumns as $column): ?>

            case $this->crudModelsClass['main'] . '.<?= $column[1]->name ?>':
                $oldPath = $this->uploadConfig[$this->crudModelsClass['main']][$attributeName]['basePath']
                    . '/' .$fileName;
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
                break;<?php endforeach; ?>

            default:
                break;
        }
    }

    /**
     * @inheritdoc
     */
    protected function getDropDownList($id)
    {
        if (!isset($this->dropDownLists[$id])) {
            switch ($id) {<?php foreach ($dropDownLists as $name => $dropDownList): ?>

                case '<?= $name ?>':
                    $this->dropDownLists['<?= $name ?>'] = <?= $dropDownList."\n"; ?>
                    break;<?php endforeach; ?>

                default:
                    return [];
                    break;
            }
        }

        return $this->dropDownLists[$id];
    }

    /**
     * @inheritdoc
     */
    protected function getAdvancedDropDownList($id, $search)
    {
        switch ($id) {<?php foreach ($advancedDropDownLists as $name => $advDropDownList): ?>

            case '<?= $name ?>':
                return <?= $advDropDownList."\n"; ?>
                break;<?php endforeach; ?>

            default:
                return [];
                break;
        }
    }
}