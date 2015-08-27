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
use yii\db\ActiveRecord;
use kalibao\common\components\i18n\I18N;
use kalibao\common\components\export\ActiveRecordCsv;

/**
 * Class ExportCsv
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
 */
class ExportCsv extends ActiveRecordCsv
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setHeader([
<?php foreach ($columns as $column): ?>
<?php if (isset($column[4])): ?>
            '<?= Inflector::camel2id($column[4][0], '_').'_'.$column[4][1] ?>' => true,
<?php elseif ($column[2] != 'main'): ?>
            '<?= Inflector::camel2id($column[0], '_').'_'.$column[1]->name ?>' => true,
<?php else: ?>
<?php if ($column[1]->name == 'ID' || $column[1]->name == 'id'): ?>
            '#',
<?php else: ?>
            '<?= $column[1]->name ?>' => true,
<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getRow(ActiveRecord $model)
    {
        return [
<?php foreach ($columns as $column): ?>
<?php if (isset($column[4])): ?>
<?php if ($column[1]->name == 'created_at' || $column[1]->name == 'updated_at'): ?>
            isset($model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]) ? Yii::$app->formatter->asDatetime($model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]-><?= $column[4][1] ?>, I18N::getDateFormat()) : '',
<?php else: ?>
<?php if ($column[4][2]): ?>
            isset($model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]) ? $model-><?= lcfirst(Inflector::pluralize($column[4][0])) ?>[0]-><?= $column[4][1] ?> : '',
<?php else: ?>
            isset($model-><?= lcfirst($column[4][0]) ?>) ? $model-><?= lcfirst($column[4][0]) ?>-><?= $column[4][1] ?> : '',
<?php endif; ?>
<?php endif; ?>
<?php elseif ($column[2] != 'main'): ?>
            isset($model-><?= lcfirst(Inflector::pluralize($column[0])) ?>[0]) ? $model-><?= lcfirst(Inflector::pluralize($column[0])) ?>[0]-><?= $column[1]->name ?> : '',
<?php elseif (in_array($column[3], [$generator::TYPE_DATE_AUTO, $generator::TYPE_DATE_INPUT])): ?>
            Yii::$app->formatter->asDatetime($model-><?= $column[1]->name ?>, I18N::getDateFormat()),
<?php elseif ($column[3] ==$generator::TYPE_IMAGE_INPUT || $column[3] ==$generator::TYPE_FILE_INPUT): ?>
            ($model-><?= $column[1]->name ?> != '')
                ?
                    $this->uploadConfig[(new \ReflectionClass($this->model))
                        ->getParentClass()->name]['<?= $column[1]->name ?>']['baseUrl'] . '/' . $this->model-><?= $column[1]->name."\n" ?>
                :
                    ''
            ,
<?php else: ?>
            $model-><?= $column[1]->name ?>,
<?php endif; ?>
<?php endforeach; ?>
        ];
    }
}