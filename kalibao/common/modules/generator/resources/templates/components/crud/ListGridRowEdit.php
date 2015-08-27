<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Inflector;

echo "<?php\n";
?>
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace <?= $namespace ?>;

use Yii;
use yii\helpers\Url;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\i18n\I18N;
<?php foreach ($columns as $column): ?>
<?php if($column[3] == $generator::TYPE_ADVANCED_DROP_DOWN || $column[3] == $generator::TYPE_DROP_DOWN): ?>
<?php
$name = $column[4][0];
if (substr($column[4][0], -4) == 'I18n') {
    $name = substr($name, 0, - 4);
}
?>
use kalibao\common\models\<?= lcfirst($name); ?>\<?= $column[4][0]; ?>;
<?php endif; ?>
<?php endforeach; ?>

/**
 * Class ListGridRowEdit
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
 */
class ListGridRowEdit extends \kalibao\common\components\crud\ListGridRowEdit
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // models
        $models = $this->getModels();

        // language
        $language = $this->getLanguage();

        // get drop down list methods
        $dropDownList = $this->getDropDownList();

        // upload config
        $uploadConfig['main'] = $this->uploadConfig[(new \ReflectionClass($models['main']))->getName()];

        // set items
        $items = [];
<?php foreach ($columns as $column): ?>

<?php if ($column[1]->autoIncrement === true): ?>
        $items[] = new SimpleValueField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'value' => $models['<?= $column[2]; ?>']-><?= $column[1]->name; ?>,
        ]);
<?php elseif($column[3] == $generator::TYPE_FILE_INPUT): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeFileInput',
            'options' => [
                'maxlength' => true,
                'class' => 'input-advanced-uploader',
                'placeholder' => $models['<?= $column[2]; ?>']->getAttributeLabel('<?= $column[1]->name; ?>'),
                'data-type-uploader' => $uploadConfig['<?= $column[2]; ?>']['<?= $column[1]->name; ?>']['type'],
                'data-file-url' => ($models['<?= $column[2]; ?>']-><?= $column[1]->name; ?> != '') ?
                    $uploadConfig['main']['<?= $column[1]->name; ?>']['baseUrl'] . '/'
                    . $models['<?= $column[2]; ?>']-><?= $column[1]->name; ?> : '',
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_IMAGE_INPUT): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeFileInput',
            'options' => [
                'class' => 'input-advanced-uploader',
                'placeholder' => $models['main']->getAttributeLabel('<?= $column[1]->name; ?>'),
                'data-type-uploader' => $uploadConfig['<?= $column[2]; ?>']['<?= $column[1]->name; ?>']['type'],
                'data-img-src' => ($models['<?= $column[2]; ?>']-><?= $column[1]->name; ?> != '') ?
                    $uploadConfig['main']['<?= $column[1]->name; ?>']['baseUrl'] . '/'
                    . $models['<?= $column[2]; ?>']-><?= $column[1]->name; ?> : '',
                'data-img-size-width' => '300px',
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_CHECKBOX): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeCheckbox',
            'options' => [
                'class' => '',
                'label' => '',
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_DATE_AUTO): ?>
        $items[] = new SimpleValueField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'value' => Yii::$app->formatter->asDatetime($models['<?= $column[2]; ?>']-><?= $column[1]->name; ?>, I18N::getDateFormat())
        ]);
<?php elseif($column[3] == $generator::TYPE_DATE_INPUT): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm date-picker date-range',
                'maxlength' => true,
                'placeholder' => $models['<?= $column[2]; ?>']->getAttributeLabel('<?= $column[1]->name; ?>'),
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_TEXTAREA): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm',
                'placeholder' => $models['<?= $column[2]; ?>']->getAttributeLabel('<?= $column[1]->name; ?>'),
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_WYSIWYG_TEXTAREA): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeTextarea',
            'options' => [
                'class' => 'form-control input-sm wysiwyg-textarea',
                'data-ckeditor-language' => $language
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_ADVANCED_DROP_DOWN): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeHiddenInput',
            'options' => [
                'class' => 'form-control input-sm input-ajax-select',
                'data-action' => Url::to([
                    'advanced-drop-down-list',
                    'id' => '<?= Inflector::camel2id($column[4][0], '_') ?>.<?= $column[4][1]; ?>',
                ]),
                'data-allow-clear' => 1,
                'data-placeholder' => Yii::t('kalibao', 'input_select'),
                'data-text' => !empty($models['<?= $column[2]; ?>']-><?= $column[1]->name; ?>) ? <?= $column[4][0] ?>::findOne([
                    '<?= $column[4][3]; ?>' => $models['<?= $column[2]; ?>']-><?= $column[1]->name; ?><?= $column[4][2] ? ",\n".'                    \'i18n_id\' => $language'."\n" : "\n".''; ?>
                ])-><?= $column[4][1]; ?> : '',
            ]
        ]);
<?php elseif($column[3] == $generator::TYPE_DROP_DOWN): ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeDropDownList',
            'data' => $dropDownList('<?= Inflector::camel2id($column[4][0], '_') ?>.<?= $column[4][1]; ?>'),
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['<?= $column[2]; ?>']->getAttributeLabel('<?= $column[1]->name; ?>'),
            ]
        ]);
<?php else: ?>
        $items[] = new InputField([
            'model' => $models['<?= $column[2]; ?>'],
            'attribute' => '<?= $column[1]->name; ?>',
            'type' => 'activeTextInput',
            'options' => [
                'class' => 'form-control input-sm',
                'maxlength' => true,
                'placeholder' => $models['<?= $column[2]; ?>']->getAttributeLabel('<?= $column[1]->name; ?>'),
            ]
        ]);
<?php endif; ?>
<?php endforeach; ?>

        $this->setItems($items);
    }
}