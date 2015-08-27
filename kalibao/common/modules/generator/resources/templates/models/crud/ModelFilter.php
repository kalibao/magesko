<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Inflector;
use yii\db\Schema;

echo "<?php\n";
?>
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace <?= $namespace ?>;

use Yii;
use yii\data\ActiveDataProvider;
use kalibao\common\components\crud\ModelFilterInterface;
<?php foreach($use as $path): ?>
use <?= $path; ?>;
<?php endforeach; ?>

/**
 * This is the model filter class for controller "<?= $generator->controller ?>".
 *
<?php foreach ($columns as $data): ?>
<?php $columnName = ($className === $data[0]) ? $data[1]->name : Inflector::camel2id($data[0], '_').'_'.$data[1]->name ?>
<?php if ($data[1]->name === 'created_at' || $data[1]->name === 'updated_at'): ?>
 * @property <?= "{$data[1]->phpType} \${$columnName}_start\n" ?>
 * @property <?= "{$data[1]->phpType} \${$columnName}_end\n" ?>
<?php else: ?>
 * @property <?= ($data[1]->type == 'bigint' ? 'integer' : $data[1]->phpType)." \${$columnName}\n" ?>
<?php endif ?>
<?php endforeach ?>
 *
 * @package <?= $namespace."\n" ?>
 * @version <?= $generator->version."\n" ?>
 */
class ModelFilter extends <?= $extendedClass ?> implements ModelFilterInterface
{
<?php foreach ($columns as $data): ?>
<?php if ($data[1]->name === 'created_at' || $data[1]->name === 'updated_at'): ?>
    <?= "public \${$data[1]->name}_start;\n" ?>
    <?= "public \${$data[1]->name}_end;\n" ?>
<?php elseif ($className !== $data[0]) : ?>
    <?= "public \$".Inflector::camel2id($data[0], '_').'_'.$data[1]->name.";\n" ?>
<?php endif ?>
<?php endforeach ?>

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                <?= implode(', ', $scenarios['default'])."\n"; ?>
            ]
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
<?php foreach ($columns as $data): ?>
<?php
$isMainClass = ($className === $data[0]);
$classNameRelation = Inflector::camel2id($data[0], '_');
$columnName = $isMainClass ? $data[1]->name : Inflector::camel2id($data[0], '_').'_'.$data[1]->name
?>
<?php if (!$isMainClass): ?>
            <?= "'$columnName' => Yii::t('".$generator->translateGroup."','".$columnName."'),\n" ?>
<?php endif ?>
<?php endforeach; ?>
        ];
    }

    /**
     * @inheritdoc
     */
    public function search($requestParams, $language = null, $pageSize = 10)
    {
        $query = self::find();
<?php
$joinWithData = [];
foreach ($columns as $data) {
    if($data[0] !== $className) {
        $isLanguage = (substr_compare($data[0], 'I18n', -4, 4, true) === 0);
        foreach ($relations as $key => $relation) {
            if ($relation[1] == $data[0]) {
                $classNameRelation = $key;
                break;
            }
        }
        if (!isset($joinWithData[$classNameRelation])) {
            $joinWithData[$classNameRelation]['isLanguage'] = $isLanguage;
            $joinWithData[$classNameRelation]['link'] = Inflector::camel2id($data[0], '_');
            $joinWithData[$classNameRelation]['columns'][] = "'".($isLanguage ? key($relations[$classNameRelation][4]) : reset($relations[$classNameRelation][4]))."'";
        }
        $joinWithData[$classNameRelation]['columns'][] = "'".$data[1]->name."'";
    }
}
?>
<?php foreach ($joinWithData as $classNameRelation => $joinData): ?>
<?php if ( ! isset($joinWith)) : $joinWith = true;  ?>
        $query->joinWith([<?php endif ?>

            '<?= lcfirst($classNameRelation); ?>' => function ($query) use ($language) {
                $query->select([<?= implode(', ',$joinData['columns']); ?>])<?= $joinData['isLanguage'] ? '->onCondition([\''.$joinData['link'].'.i18n_id\' => $language])' : ''; ?>;
            },<?php endforeach; ?>

<?php if ( isset($joinWith)) : ?>
        ]);
<?php endif ?>

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
<?php foreach ($columns as $data): ?>
<?php
    $isMainClass = ($className === $data[0]);
    $classNameRelation = Inflector::camel2id($data[0], '_');
    $columnName = $isMainClass ? $data[1]->name : Inflector::camel2id($data[0], '_').'_'.$data[1]->name
?>
<?php if ($isMainClass): ?>
                    '<?= $columnName; ?>',
<?php else: ?>
                    '<?= $columnName; ?>' => [
                        'asc' => ['<?= $classNameRelation.'.'.$data[1]->name; ?>' => SORT_ASC],
                        'desc' => ['<?= $classNameRelation.'.'.$data[1]->name; ?>' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('<?= $columnName ?>')
                    ],
<?php endif ?>
<?php endforeach; ?>
                ],
                'defaultOrder' => [
                    '<?= $tableSchema->primaryKey[0] ?>' => SORT_DESC
                ]
            ],
            'pagination' => [
                'defaultPageSize' => $pageSize,
                'pageSize' => $pageSize,
            ]
        ]);

        $this->load($requestParams);

        if (! $this->validate()) {
            return $dataProvider;
        }

<?php foreach ($columns as $data): ?>
<?php if ($data[1]->name === 'created_at' || $data[1]->name === 'updated_at'): ?>
<?php $classNameRelation = Inflector::camel2id($data[0], '_'); ?>
        $query->andFilterWhere(['>=', '<?= $classNameRelation ?>.<?= $data[1]->name; ?>', $this-><?= $data[1]->name; ?>_start]);
        if ($this-><?= $data[1]->name; ?>_end != '') {
            $query->andWhere([
                '<=',
                '<?= $classNameRelation ?>.<?= $data[1]->name; ?>',
                (new \DateTime($this-><?= $data[1]->name; ?>_end))->modify('+1 day')->format('Y-m-d')
            ]);
        }
<?php endif ?>
<?php endforeach ?>

        $query<?php $nb = count($columns) - 1; $i = 0; foreach ($columns as $data): ?>
<?php
    $isMainClass = ($className === $data[0]);
    $classNameRelation = Inflector::camel2id($data[0], '_');
    if (($isMainClass && ! in_array($data[1]->name, ['created_at', 'updated_at'])) || !$isMainClass) :
        $columnName = $isMainClass ? $data[1]->name : Inflector::camel2id($data[0], '_').'_'.$data[1]->name
?>
<?php if (in_array($data[1]->type, [Schema::TYPE_STRING, Schema::TYPE_TEXT])): ?>

            ->andFilterWhere(['like', '<?= $classNameRelation ?>.<?= $data[1]->name; ?>', $this-><?= $columnName; ?>])<?php else: ?>

            ->andFilterWhere(['<?= $classNameRelation ?>.<?= $data[1]->name; ?>' => $this-><?= $columnName; ?>])<?php endif; ?>
<?php endif ?>
<?php ++$i ?>
<?php endforeach ?>;

        return $dataProvider;
    }
}
