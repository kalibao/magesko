/**
 * View component of crud
 *
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Cassian Assael <cassian_as@yahoo.fr>
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.tree = $.kalibao.backend.tree || {};

  /**
   * View component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.tree.View = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.treeData = args['treeData'];
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.tree.Edit}
   */
  $.kalibao.backend.tree.View.prototype = Object.create($.kalibao.crud.Edit.prototype);

  /**
   * Init object
   */
  $.kalibao.backend.tree.View.prototype.init = function () {
    var self = this;
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.$tree = this.$container.find('#tree');
    this.$branchContainer = this.$container.find('#branch-container');
    this.initComponents();
    this.initEvents();
  };

  /**
   * Init events
   */
  $.kalibao.backend.tree.View.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initTreeEvents();
  };

  /**
   * Init components
   */
  $.kalibao.crud.Edit.prototype.initComponents = function () {
    this.initValidators(this.validators, this.activeValidators);
    this.initAdvancedDropDownList(this.$main);
    this.initDatePicker(this.$main);
    this.initWysiwig(this.$main);
    this.initUploader(this.$main);
    /*this.$tree.jstree({
      'core': {
        'data'     : this.treeData,
        'multiple' : false,
        'check_callback' : true
      },
      'plugins' : ['contextmenu', 'dnd', 'unique', 'changed', '']
    });*/
  };

  /**
   * Init tree events
   */
  $.kalibao.backend.tree.View.prototype.initTreeEvents = function () {
    var self = this;
    this.$tree.on('click', '.fa', function(e, data){
      e.stopPropagation();
      console.log(e.target.id)
    });
    this.$tree.on('set_text.jstree', function(e, data){
      console.log(data.obj);
      self.$tree.jstree().deselect_all();
      self.$tree.jstree().select_node(data.obj)
    });
  };

  /**
   * returns the value of the url parameter (similar to $_GET() in php)
   * @param name string The param name
   * @returns {*} The value of the url param
   */
  $.kalibao.backend.tree.View.prototype.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
      return null;
    }
    else{
      return results[1] || 0;
    }
  };


})(jQuery);
