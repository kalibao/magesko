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
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\InputField;
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
 * Class ListGrid
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
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
        $this->setTitle(Yii::t('kalibao', 'list_title'));

        // set head attributes
        $this->setGridHeadAttributes([
<?php foreach ($columns as $column): ?>
<?php if (isset($column[4])): ?>
            '<?= Inflector::camel2id($column[4][0], '_').'_'.$column[4][1] ?>' => true,
<?php elseif ($column[2] != 'main'): ?>
            '<?= Inflector::camel2id($column[0], '_').'_'.$column[1]->name ?>' => true,
<?php else: ?>
            '<?= $column[1]->name ?>' => true,
<?php endif; ?>
<?php endforeach; ?>
        ]);

        // set head filters
        $this->setGridHeadFilters([
<?php foreach ($columns as $column): ?>
<?php $columnName = ''; ?>
<?php if (isset($column[4])): ?>
<?php $columnName = Inflector::camel2id($column[4][0], '_').'_'.$column[4][1]; ?>
<?php elseif ($column[2] != 'main'): ?>
<?php $columnName = Inflector::camel2id($column[0], '_').'_'.$column[1]->name; ?>
<?php else: ?>
<?php $columnName = $column[1]->name; ?>
<?php endif; ?>
<?php if($column[3] == $generator::TYPE_CHECKBOX): ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('checkbox-drop-down-list'),
                'options' => [
                    'class' => 'form-control input-sm',
                ]
            ]),
<?php elseif($column[3] == $generator::TYPE_DATE_AUTO): ?>
            new DateRangeField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'start' => new InputField([
                    'model' => $model,
                    'attribute' => '<?= $columnName ?>_start',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ]),
                'end' => new InputField([
                    'model' => $model,
                    'attribute' => '<?= $columnName ?>_end',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ])
            ]),
<?php elseif($column[3] == $generator::TYPE_DATE_INPUT): ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm date-picker date-range',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
<?php elseif($column[3] == $generator::TYPE_ADVANCED_DROP_DOWN): ?>
            new InputField([
                'model' => $model,
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
                    'data-text' => !empty($model-><?= $column[1]->name; ?>) ? <?= $column[4][0] ?>::findOne([
                        '<?= $column[4][3]; ?>' => $model-><?= $column[1]->name; ?><?= $column[4][2] ? ",\n".'                        \'i18n_id\' => $language'."\n" : "\n".''; ?>
                    ])-><?= $column[4][1]; ?> : '',
                ]
            ]),
<?php elseif($column[3] == $generator::TYPE_DROP_DOWN): ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $column[1]->name; ?>',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('<?= Inflector::camel2id($column[4][0], '_') ?>.<?= $column[4][1]; ?>'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
<?php else: ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'type' => 'activeTextInput',
                    'options' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
<?php endif; ?>
<?php endforeach; ?>
        ]);

        // set advanced filters
        $this->setAdvancedFilters([
<?php foreach ($columns as $column): ?>
<?php $columnName = ''; ?>
<?php if (isset($column[4])): ?>
<?php $columnName = Inflector::camel2id($column[4][0], '_').'_'.$column[4][1]; ?>
<?php elseif ($column[2] != 'main'): ?>
<?php $columnName = Inflector::camel2id($column[0], '_').'_'.$column[1]->name; ?>
<?php else: ?>
<?php $columnName = $column[1]->name; ?>
<?php endif; ?>
<?php if($column[3] == $generator::TYPE_CHECKBOX): ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('checkbox-drop-down-list'),
                'options' => [
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                    'class' => 'form-control input-sm',
                ]
            ]),
<?php elseif($column[3] == $generator::TYPE_DATE_AUTO): ?>
            new DateRangeField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'start' => new InputField([
                    'model' => $model,
                    'attribute' => '<?= $columnName ?>_start',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ]),
                'end' => new InputField([
                    'model' => $model,
                    'attribute' => '<?= $column[1]->name; ?>_end',
                    'type' => 'activeTextInput',
                    'options' => [
                        'placeholder' => Yii::t('kalibao', 'input_search'),
                        'maxlength' => true,
                        'class' => 'form-control input-sm date-picker date-range',
                    ]
                ])
            ]),
<?php elseif($column[3] == $generator::TYPE_DATE_INPUT): ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm date-picker date-range',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
<?php elseif($column[3] == $generator::TYPE_ADVANCED_DROP_DOWN): ?>
            new InputField([
                'model' => $model,
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
                'data-text' => !empty($model-><?= $column[1]->name; ?>) ? <?= $column[4][0] ?>::findOne([
                        '<?= $column[4][3]; ?>' => $model-><?= $column[1]->name; ?><?= $column[4][2] ? ",\n".'                        \'i18n_id\' => $language'."\n" : "\n".''; ?>
                    ])-><?= $column[4][1]; ?> : '',
                ]
            ]),
<?php elseif($column[3] == $generator::TYPE_DROP_DOWN): ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $column[1]->name; ?>',
                'type' => 'activeDropDownList',
                'data' => $dropDownList('<?= Inflector::camel2id($column[4][0], '_') ?>.<?= $column[4][1]; ?>'),
                'options' => [
                    'class' => 'form-control input-sm',
                    'maxlength' => true,
                    'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
<?php else: ?>
            new InputField([
                'model' => $model,
                'attribute' => '<?= $columnName ?>',
                'type' => 'activeTextInput',
                'options' => [
                    'class' => 'form-control input-sm',
                'placeholder' => Yii::t('kalibao', 'input_search'),
                ]
            ]),
<?php endif; ?>
<?php endforeach; ?>
        ]);
    }
}