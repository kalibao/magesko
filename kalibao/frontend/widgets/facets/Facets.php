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
use kalibao\common\models\product\Product;
use Yii;
use yii\caching\TagDependency;
use yii\web\View;

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

        $counts = Product::countByAttribute(
            ['branch_id' => $this->branch]
        );
        if (!$counts) {
            $this->models['count'] = [];
        } else {
            foreach ($counts as $count) {
                $this->models['count'][$count['attribute_id']] = $count['number'];
            }
        }
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
//        var_dump($this->models['count']);
        $html = '<div class="panel panel-default">
    <div class="panel-heading">
        Facettes
    </div>
    <div id="facets-container" class="panel-body">';
        foreach ($this->models['attribute_types_ids'] as $k){
            $html .= $this->models['attribute_types_names'][$k] . '<ul>';
            foreach ($this->models['attribute_types_content'][$k] as $id => $value) {
                if (!array_key_exists($id, $this->models['count'])) continue;
                $html .= '<li data-id="'. $id .'"><input type="checkbox">' . $value . ' (' . $this->models['count'][$id] . ')</li>';
            }
            $html .= '</ul>';
        }
        $html .= '</div></div>';
        return $html;
    }

    public static function getJs()
    {
        return <<<'JS'
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
(function ($) {
  'use strict';
  $.kalibao = $.kalibao || {};
  $.kalibao.frontend = $.kalibao.frontend || {};
  $.kalibao.frontend.facets = $.kalibao.frontend.facets || {};

  /**
   * Nav component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.frontend.facets.Nav = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Init object
   */
  $.kalibao.frontend.facets.Nav.prototype.init = function () {
    var self = this;
    this.$facetsContainer = $('#facets-container');
    this.$productsZone = $('#products');
    this.currentFacets = {};

    this.initEvents();
    this.initFacets();
  };

  /**
   * Init events
   */
  $.kalibao.frontend.facets.Nav.prototype.initEvents = function () {
    var self = this;
    this.$facetsContainer.find('input').change(function(){
      self.$productsZone.block($.extend($.blockUI.defaults, {
        message: '&nbsp;'
      }));
      var $el = $(this);
      var type = $el.closest('ul')[0].previousSibling.nodeValue;
      self.currentFacets[type] = self.currentFacets[type] || [];
      if ($el.is(':checked')) {
        self.currentFacets[type].push($el.parent().text().split(' ')[0] + ':' + $el.parent().data('id'));
      } else {
        self.currentFacets[type].remove($el.parent().text().split(' ')[0] + ':' + $el.parent().data('id'))
      }
      var filters = JSON.stringify(self.currentFacets);
      var cat = self.urlParam('cat');
      window.location.hash = btoa(filters);
      $.post('/fr/category_filtered', {filters: filters, cat: cat}, function(response){
        self.$productsZone.html(response)
      });
    })
  };

  /**
   * Init facets
   */
  $.kalibao.frontend.facets.Nav.prototype.initFacets = function () {
    var self = this;
    if (window.location.hash == '') return;
    try {
      this.currentFacets = JSON.parse(atob(window.location.hash.substr(1)));
    } catch(e) {
      console.log('invalid hash');
      return;
    }
    $.each(this.currentFacets, function(){
      $.each(this, function(){
        self.$facetsContainer.find('[data-id='+this.split(':')[1]+']').find('input').prop('checked', true);
      });
      var filters = JSON.stringify(self.currentFacets);
      var cat = self.urlParam('cat');
      var route = window.location.pathname.substr(window.location.pathname.indexOf('/', 1) + 1);
      $.post('/fr/category_filtered', {filters: filters, cat: cat, route: route}, function(response){
        self.$productsZone.html(response)
      });
    })
  };

  /**
   * returns the value of the url parameter (similar to $_GET() in php)
   * @param name string The param name
   * @returns {*} The value of the url param
   */
  $.kalibao.frontend.facets.Nav.prototype.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
      return null;
    }
    else{
      return results[1] || 0;
    }
  };

})(jQuery);
new $.kalibao.frontend.facets.Nav({});
JS;
    }
}
