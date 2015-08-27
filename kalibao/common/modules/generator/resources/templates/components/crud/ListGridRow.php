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
use kalibao\common\components\helpers\Html;
use kalibao\common\components\i18n\I18N;

/**
 * Class ListGridRow
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
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
<?php foreach ($columns as $column): ?>
<?php if (isset($column[4])): ?>
<?php if ($column[1]->name == 'created_at' || $column[1]->name == 'updated_at'): ?>
            isset($this->model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]) ? Yii::$app->formatter->asDatetime($this->model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]-><?= $column[4][1] ?>, I18N::getDateFormat()) : '',
<?php else: ?>
<?php if ($column[4][2]): ?>
            isset($this->model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]) ? $this->model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]-><?= $column[4][1] ?> : '',
<?php else: ?>
            isset($this->model-><?= lcfirst($column[4][0]) ?>) ? $this->model-><?= lcfirst($column[4][0]) ?>-><?= $column[4][1] ?> : '',
<?php endif; ?>
<?php endif; ?>
<?php elseif ($column[2] != 'main'): ?>
            isset($this->model-><?= lcfirst(Inflector::pluralize($column[0])) ?>[0]) ? $this->model-><?= lcfirst(Inflector::pluralize($column[0])) ?>[0]-><?= $column[1]->name ?> : '',
<?php elseif (in_array($column[3], [$generator::TYPE_DATE_AUTO, $generator::TYPE_DATE_INPUT])): ?>
            Yii::$app->formatter->asDatetime($this->model-><?= $column[1]->name ?>, I18N::getDateFormat()),
<?php elseif ($column[3] ==$generator::TYPE_IMAGE_INPUT): ?>
            ($this->model-><?= $column[1]->name ?> != '')
                ?
                    Html::img(
                        $this->uploadConfig[(new \ReflectionClass($this->model))
                            ->getParentClass()->name]['<?= $column[1]->name ?>']['baseUrl'] . '/' . $this->model-><?= $column[1]->name ?>,
                        ['width' => '200px', 'class' => 'overview'])
                :
                    '',
<?php elseif ($column[3] ==$generator::TYPE_FILE_INPUT): ?>
            ($this->model-><?= $column[1]->name ?> != '')
                ?
                    Html::a(
                        $this->model->fichier,
                        $this->uploadConfig[(new \ReflectionClass($this->model))
                            ->getParentClass()->name]['<?= $column[1]->name ?>']['baseUrl'] . '/' . $this->model-><?= $column[1]->name ?>,
                        ['target' => '_blank']
                    )
                :
                    '',
<?php elseif ($column[3] == $generator::TYPE_CHECKBOX): ?>
            Html::activeCheckbox($this->model, '<?= $column[1]->name ?>', ['disabled' => 'disabled', 'label' => '']),
<?php else: ?>
            $this->model-><?= $column[1]->name ?>,
<?php endif; ?>
<?php endforeach; ?>
        ]);
    }
}