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
<?php if (isset($tableSchema->columns['created_at']) && isset($tableSchema->columns['updated_at'])) : ?>
use yii\behaviors\TimestampBehavior;
<?php endif; ?>
<?php if (!empty($relations[$className])): ?>
<?php foreach ($relations[$className] as $name => $relation): ?>
<?php
    $pathClassName = $relation[1];
    if (substr($pathClassName, -4) == 'I18n') {
        $pathClassName = lcfirst(substr($pathClassName, 0, -4)).'\\'.$pathClassName;
    } else {
        $pathClassName = lcfirst($pathClassName).'\\'.$pathClassName;
    }
?>
use kalibao\common\models\<?= $pathClassName . ";\n" ?>
<?php endforeach ?>
<?php endif ?>

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= ($column->type == 'bigint' ? 'integer' : $column->phpType)." \${$column->name}\n" ?>
<?php endforeach ?>
<?php if (!empty($relations[$className])): ?>
 *
<?php foreach ($relations[$className] as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach ?>
<?php endif ?>
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
 */
class <?= $className ?> extends \yii\db\ActiveRecord
{
<?php if (isset($tableSchema->columns['created_at']) && isset($tableSchema->columns['updated_at'])) : ?>
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function ($event) {
                    return date('Y-m-d h:i:s');
                },
            ]
        ];
    }

<?php endif ?>
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif ?>

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'insert' => [
                <?= implode(', ', $scenarios['insert'])."\n"; ?>
            ],
            'update' => [
                <?= implode(', ', $scenarios['update'])."\n"; ?>
            ],
<?php if ($isI18n): ?>
            'translate' => [
                <?= implode(', ', $scenarios['translate'])."\n"; ?>
            ],
            'beforeInsert' => [
                <?= implode(', ', $scenarios['beforeInsert'])."\n"; ?>
            ]
<?php endif; ?>
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => Yii::t('".(in_array($name, ['created_at', 'updated_at']) ? 'kalibao' : $generator->translateGroup)."','".(in_array($name, ['created_at', 'updated_at']) ? 'model:'.$name : addslashes($label))."'),\n" ?>
<?php endforeach ?>
        ];
    }
<?php foreach ($relations[$className] as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach ?>
}
