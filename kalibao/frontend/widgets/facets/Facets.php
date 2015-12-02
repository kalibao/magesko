<?php
/**
 * @copyright Copyright (c) 2015 - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\widgets\facets;

use kalibao\common\components\cms\CmsMenuSimpleService;
use kalibao\common\models\attribute\Attribute;
use kalibao\common\models\attribute\AttributeI18n;
use kalibao\common\models\attributeType\AttributeType;
use kalibao\common\models\attributeType\AttributeTypeI18n;
use kalibao\common\models\attributeTypeVisibility\AttributeTypeVisibility;
use kalibao\common\models\branch\Branch;
use Yii;
use yii\caching\TagDependency;

class Facets extends \yii\base\Widget
{
    /**
     * @var int Branch ID
     */
    public $branch;

    /**
     * @var array Models
     */
    protected $models;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->branch === null) return; //not in a branch => no facets

        $this->models['attribute_types_ids'] = Branch::getDb()->cache(
            function ($db) {
                $res = AttributeTypeVisibility::find()
                    ->where([
                        'branch_id' => $this->branch
                    ])
                    ->select('attribute_type_id as id')
                    ->orderBy('order')
                    ->asArray()
                    ->all();
                $data = [];
                foreach($res as $r) {
                    $data[] = $r['id'];
                }
                return $data;
            },
            0,
            new TagDependency([
                'tags' => [
                    CmsMenuSimpleService::getCacheTag(),
                    CmsMenuSimpleService::getCacheTag($this->branch),
                ],
            ])
        );

        $this->models['attribute_types_names'] = AttributeTypeI18n::getDb()->cache(
            function ($db) {
                $res = AttributeTypeI18n::find()
                    ->select('value, attribute_type_id')
                    ->where(['attribute_type_id' => $this->models['attribute_types_ids']])
                    ->asArray()
                    ->all();
                $data = [];
                foreach($res as $r) {
                    $data[$r['attribute_type_id']] = $r['value'];
                }
                return $data;
            },
            0,
            new TagDependency([
                'tags' => [
                    CmsMenuSimpleService::getCacheTag(),
                    CmsMenuSimpleService::getCacheTag(null),
                ],
            ])
        );

        $this->models['attribute_types_content'] = Attribute::getDb()->cache(
            function ($db) {
                $res = Attribute::find()
                    ->innerJoinWith('attributeI18ns')
                    ->select('value, id, attribute_type_id')
                    ->where(['attribute_type_id' => $this->models['attribute_types_ids']])
                    ->asArray()
                    ->all();
                $data = [];
                foreach($res as $r) {
                    $data[$r['attribute_type_id']][$r['id']] = $r['value'];
                }
                return $data;
            },
            0,
            new TagDependency([
                'tags' => [
                    CmsMenuSimpleService::getCacheTag(),
                    CmsMenuSimpleService::getCacheTag(null),
                ],
            ])
        );
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->branch === null) return '';
//        var_dump($this->models['attribute_types_ids']);
//        var_dump($this->models['attribute_types_names']);
//        var_dump($this->models['attribute_types_content']);
        $html = '<div class="facets"><ul>';
        foreach ($this->models['attribute_types_names'] as $k => $type){
            $html .= '<li>' . $type . '<ul>';
            foreach ($this->models['attribute_types_content'][$k] as $id => $value) {
                $html .= '<li>' . $value . '</li>';
            }
            $html .= '</ul></li>';
        }
        $html .= '</ul></div>';
        return $html;
    }
}