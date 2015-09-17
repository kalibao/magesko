<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\helpers;

use Yii;
use kalibao\common\components\i18n\I18N;
use yii\data\Sort;
use yii\helpers\Inflector;

/**
 * Class Html overload the default Html component in order to add new features
 *
 * @package kalibao\common\components\helpers
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
class Html extends \yii\helpers\Html
{
    /**
     * Generates a summary of the validation errors.
     * If there is no validation error, an empty error summary markup will still be generated, but it will be hidden.
     * @param Model|Model[] $models the model(s) whose validation errors are to be displayed
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - header: string, the header HTML for the error summary. If not set, a default prompt string will be used.
     * - footer: string, the footer HTML for the error summary.
     * - encode: boolean, if set to false then value won't be encoded.
     *
     * The rest of the options will be rendered as the attributes of the container tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * @return string the generated error summary
     */
    public static function errorSummary($models, $options = [])
    {
        $header = isset($options['header']) ? $options['header'] : '<p>' . Yii::t('yii', 'Please fix the following errors:') . '</p>';
        $footer = isset($options['footer']) ? $options['footer'] : '';
        $encode = !isset($options['encode']) || $options['encode'] !== false;
        unset($options['header'], $options['footer'], $options['encode']);

        $lines = [];
        if (!is_array($models)) {
            $models = [$models];
        }
        self::getErrorLines($models, $lines, $encode);

        if (empty($lines)) {
            // still render the placeholder for client-side validation use
            $content = "<ul></ul>";
            $options['style'] = isset($options['style']) ? rtrim($options['style'], ';') . '; display:none' : 'display:none';
        } else {
            $content = "<ul><li>" . implode("</li>\n<li>", $lines) . "</li></ul>";
        }
        return Html::tag('div', $header . $content . $footer, $options);
    }

    /**
     * Get error lines
     * @param array $models
     * @param array $lines
     * @param boolean $encode if set to false then value won't be encoded.
     */
    protected static function getErrorLines(array $models, array &$lines, $encode)
    {
        foreach ($models as $model) {
            if (is_array($model)) {
                self::getErrorLines($model, $lines, $encode);
            } else {
                /* @var $model Model */
                foreach ($model->getFirstErrors() as $error) {
                    $lines[] = $encode ? Html::encode($error) : $error;
                }
            }
        }
    }

    /**
     * Get data used to generate an advanced drop down list
     * @param string $modelName Model name
     * @param array $select Attributes to select
     * @param array $where Condition
     * @param int $limit Limit
     * @return array
     */
    public static function findAdvancedDropDownListData($modelName, $select, $where, $limit)
    {
        $activeQuery = (new \yii\db\Query())
            ->select($select)
            ->from((new $modelName())->tableName());

        $first = true;
        foreach ($where as $condition) {
            if ($first) {
                $activeQuery->where($condition);
                $first = false;
            } else {
                $activeQuery->andWhere($condition);
            }
        }
        $models = $activeQuery->limit($limit)->all();

        $attributeId = '';
        $attributeValue = '';

        if (!empty($models)) {
            $keys = array_keys($models[0]);
            $attributeId = $keys[0];
            $attributeValue = isset($keys[1]) ? $keys[1] : $keys[0];
        }

        return self::activeAdvancedDropDownListData($models, $attributeId, $attributeValue);
    }

    /**
     * Get data used to generate a drop down list
     * @param string $modelName Model name
     * @param array $select Attributes to select
     * @param array $where Condition
     * @return array
     */
    public static function findDropDownListData($modelName, $select, $where)
    {
        $activeQuery = (new \yii\db\Query())
            ->select($select)
            ->from((new $modelName())->tableName());

        $first = true;
        foreach ($where as $condition) {
            if ($first) {
                $activeQuery->where($condition);
                $first = false;
            } else {
                $activeQuery->andWhere($condition);
            }
        }
        $models = $activeQuery->all();

        $attributeId = '';
        $attributeValue = '';

        if (!empty($models)) {
            $keys = array_keys($models[0]);
            $attributeId = $keys[0];
            $attributeValue = isset($keys[1]) ? $keys[1] : $keys[0];
        }

        return self::activeDropDownListData($models, $attributeId, $attributeValue);
    }

    /**
     * Get data used to generate an advanced drop down list from array of \yii\base\Model
     * @param \yii\base\Model[] $models List of models
     * @param string $attributeId Name of attribute id
     * @param string $attributeValue Name of attribute value
     * @return array
     */
    public static function activeAdvancedDropDownListData($models, $attributeId, $attributeValue)
    {
        $results = [];
        foreach ($models as $model) {
            $results[] = ['id' => $model[$attributeId], 'text' => $model[$attributeValue]];
        }
        return $results;
    }

    /**
     * Get data used to generate a drop down list from array of \yii\base\Model
     * @param \yii\base\Model[] $models List of models
     * @param string $attributeId Name of attribute id
     * @param string $attributeValue Name of attribute value
     * @return array
     */
    public static function activeDropDownListData($models, $attributeId, $attributeValue)
    {
        $results[''] = Yii::t('kalibao', 'input_select');
        foreach ($models as $model) {
            $results[$model[$attributeId]] = $model[$attributeValue];
        }
        return $results;
    }

    /**
     * Generates a hyperlink that can be clicked to cause sorting.
     * @param Sort $sort the current Sort instance
     * @param string $attribute the attribute name
     * @param array $options additional HTML attributes for the hyperlink tag.
     * There is one special attribute `label` which will be used as the label of the hyperlink.
     * If this is not set, the label defined in [[attributes]] will be used.
     * If no label is defined, [[\yii\helpers\Inflector::camel2words()]] will be called to get a label.
     * Note that it will not be HTML-encoded.
     * @return string
     */
    public static function sortLink(Sort $sort, $attribute, $options = [])
    {
        if (($direction = $sort->getAttributeOrder($attribute)) !== null) {
            $class = ($direction === SORT_DESC) ? 'current-sort desc' : 'current-sort asc';
            $icon = ($direction === SORT_DESC) ?  'glyphicon-sort-by-alphabet-alt' : 'glyphicon-sort-by-alphabet';
            if (isset($options['class'])) {
                $options['class'] .= ' ' . $class;
            } else {
                $options['class'] = $class;
            }
        } else {
            $icon = 'glyphicon-sort-by-alphabet';
            if (isset($options['class'])) {
                $options['class'] .= ' asc';
            } else {
                $options['class'] = 'asc';
            }
        }

        $url = $sort->createUrl($attribute);
        $options['data-sort'] = $sort->createSortParam($attribute);
        if (isset($options['label'])) {
            $label = $options['label'];
            unset($options['label']);
        } else {
            if (isset($sort->attributes[$attribute]['label'])) {
                $label = $sort->attributes[$attribute]['label'];
            } else {
                $label = Inflector::camel2words($attribute);
            }
        }
        $label .= ' <span class="glyphicon ' . $icon. '"></span>';
        return Html::a($label, $url, $options);
    }

    /**
     * Get drop down list filter for checkbox input
     * @return array
     */
    public static function checkboxInputFilterDropDownList()
    {
        return [
            '' => Yii::t('kalibao', 'input_drop_down_list_all'),
            '1' => Yii::t('kalibao', 'input_drop_down_list_checked'),
            '0' => Yii::t('kalibao', 'input_drop_down_list_unchecked'),
        ];
    }

    /**
     * Get language label from id
     * @param string $language Language ID
     * @param bool $flag Display flag
     * @param bool $text Display text
     * @return string HTML
     */
    public static function labelI18n($language, $flag = true, $text = true)
    {
        return '<span class="label-language">'.($flag ? '<span class="flag flag-'.$language.'"></span>' : '') .($text ? '<span class="value">'.I18N::label($language).'</span>' : ''). '</span>';
    }
}
