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
use kalibao\common\components\crud\InputField;

/**
 * Class Translate
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
 */
class Translate extends \kalibao\common\components\crud\Translate
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // model
        $model = $this->getModel();

        // language
        $language = $this->getLanguage();

        // set items
        $items = [];

<?php foreach ($columns as $column): ?>
<?php if ($column[2] == 'i18n'): ?>
<?php if($column[3] == $generator::TYPE_TEXTAREA): ?>
        $items[] = new InputField([
            'model' => $model,
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $model->getAttributeLabel('<?= $column[1]->name; ?>'),
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_WYSIWYG_TEXTAREA): ?>
        $items[] = new InputField([
            'model' => $model,
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);
<?php else: ?>
        $items[] = new InputField([
            'model' => $model,
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $model->getAttributeLabel('<?= $column[1]->name; ?>'),
            ]
        ]);
<?php endif ?>
<?php endif ?>
<?php endforeach ?>

        $this->setItems($items);
    }
}