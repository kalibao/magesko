<?php
/**
 * @copyright Copyright (c) 2015 - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\widgets\categories;

use kalibao\common\components\cms\CmsMenuSimpleService;
use kalibao\common\components\cms\CmsPageService;
use kalibao\common\components\helpers\URLify;
use kalibao\common\models\attribute\Attribute;
use kalibao\common\models\attribute\AttributeI18n;
use kalibao\common\models\attributeType\AttributeType;
use kalibao\common\models\attributeType\AttributeTypeI18n;
use kalibao\common\models\attributeTypeVisibility\AttributeTypeVisibility;
use kalibao\common\models\branch\Branch;
use kalibao\common\models\tree\Tree;
use Yii;
use yii\caching\TagDependency;

class Categories extends \yii\base\Widget
{
    /**
     * @var int Branch ID
     */
    public $branch;

    /**
     * @var array Tree data
     */
    protected $treeData;

    /**
     * @var array Tree paths
     */
    protected $treePaths;

    protected $categoryUrl;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $tree = Tree::findOne(Yii::$app->variable->get('kalibao.backend', 'catalog_tree_id'));
        $this->treeData = json_decode($tree->treeToJson(false), true);
        $this->treePaths = array_map(
            function($d){
                return URLify::filter($d);
            }
            , $tree->treeToList()
        );

        $this->categoryUrl = '/' . CmsPageService::getSlugById(47, Yii::$app->language) . '/';
    }

    private function htmlTree($data)
    {
        $html = '<ul>';
        foreach ($data as $d) {
            $id = explode('-', $d['id'])[1];
            $html .= '<li><a href="'. Yii::$app->getUrlManager()->createUrl([$this->categoryUrl . $this->treePaths[$id], 'cat' => $id]) .'">' . $d['text'] . '</a>';

            if (array_key_exists('children', $d) && is_array($d['children'])){
                $html .= $this->htmlTree($d['children']);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        //return;
        return '<div class="panel panel-default">
                    <div class="panel-heading">
                        Menu du shop
                    </div>
                    <div class="panel-body">
                        <ul>
                            <li>
                                 <a href="'.Yii::$app->getUrlManager()->createUrl([$this->categoryUrl]).'">Accueil</a>
                                 '.$this->htmlTree($this->treeData).'
                            </li>
                        </ul>
                    </div>
                </div>';
    }
}