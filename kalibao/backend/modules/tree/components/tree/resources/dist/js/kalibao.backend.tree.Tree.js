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
    this.$addButton = this.$container.find('#add-branch');
    this.$openAll = this.$container.find('#open-all');
    this.$closeAll = this.$container.find('#close-all');
    this.$saveTree = this.$container.find('#save-tree');
    this.$resetTree = this.$container.find('#reset-tree');
    this.initComponents();
    this.initEvents();
    $.kalibao.core.app.hasUnsavedChanges = function() {
      if (window.location.pathname.search('/tree/tree/view') === -1) return false;
      return self.changed;
    }
  };

  /**
   * Init events
   */
  $.kalibao.backend.tree.View.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initTreeEvents();
    this.initFilterEvents();
  };

  /**
   * Init components
   */
  $.kalibao.backend.tree.View.prototype.initComponents = function () {
    this.initValidators(this.validators, this.activeValidators);
    this.initAdvancedDropDownList(this.$main);
    this.initDatePicker(this.$main);
    this.initWysiwig(this.$main);
    this.initUploader(this.$main);
    this.initTree();

  };

  /**
   * Init tree
   */
  $.kalibao.backend.tree.View.prototype.initTree = function () {
    this.$tree.jstree({
      'core': {
        'data': this.treeData,
        'multiple': false,
        'check_callback': true,
        'themes': {
          'variant': 'large'
        }
      },
      'plugins': ['dnd', 'unique']
    });
  };

  /**
   * Init tree events
   */
  $.kalibao.backend.tree.View.prototype.initTreeEvents = function () {
    var self = this;
    this.$tree.on('click', '#add-branch', function(e){e.stopPropagation();});

    this.$tree.on('click', '.fa', function(e){ // fired when an action button is clicked in a node
      e.stopPropagation();
      var data = e.target.id.split('-');
      var $node = $(this).parent();
      var event = {
        action: data[0],
        id: data[1]
      };
      self.$tree.jstree().deselect_all(true);
      self.$tree.jstree().select_node($node, true);
      switch (event.action) {
        case 'edit':
          $.get('../branch/update?id=' + event.id, function(response){
            self.$branchContainer.html(response.html);
            self.initFilterEvents();
          });
          break;

        case 'delete':
          $.post('../branch/delete?id=' + event.id,{}, function(response){
            var modal = new $.kalibao.core.Modal({id:'modal-delete-branch'});
            modal.setHeader(response.text);
            modal.setBtnPrimary('Supprimer');
            modal.setBtnSecondary('Fermer');

            // buttons actions
            modal.$component.find('.btn-secondary, .close').on('click', function () {
              modal.close();
              return false;
            });
            modal.$component.find('.btn-primary').on('click', function () {
              $.post('../branch/delete-rows?id=' + event.id, {
                rows: ['id=' + event.id]
              }, function(){
                self.$tree.jstree().delete_node($node);
                modal.close();
                self.treeData = self.$tree.jstree().get_json();
                $.toaster({priority: 'success', title: 'Enregistré', message: 'La branche a été supprimée'})
              });
            });
            modal.open();
          }, 'json');
          break;
      }
    });

    this.$tree.on('changed.jstree', function(e, f){ // fired when a node is selected
      if (f.action != 'select_node') return;
      var data = f.node.id.split('-');
      var event = {
        branch: f.node.id,
        id: data[1]
      };
      $.get('../branch/view?id=' + event.id, function(response){
        self.$branchContainer.html(response.html);
      });
    });

    this.$tree.on('move_node.jstree', function(e, data){
      var parent = (data.parent == "#")?"#":data.parent.split('-')[1];
      self.$tree.jstree().open_node(data.parent);
      self.changed = true;
    });

    this.$saveTree.on('click', function() {
      var newData = self.$tree.jstree().get_json();
      $.post('rebuild-tree', {data: newData}, function(result) {
        if (result) {
          self.treeData = newData;
          $.toaster({priority: 'success', title: 'Enregistré', message: 'Les changements ont été enregistrés'})
          self.changed = false;
        }
      });
    });

    this.$resetTree.on('click', function() {
      self.$tree.jstree().destroy();
      self.initTree();
      self.changed = false;
    });

    this.$addButton.on('click', function(){
      $.get('../branch/create?tree=' + self.urlParam('id'), function(response){
        self.$branchContainer.html(response.html);
      });
    });

    this.$openAll.on('click', function() {
      self.$tree.jstree().open_all();
    });

    this.$closeAll.on('click', function() {
      self.$tree.jstree().close_all();
    })
  };

  /**
   * init the buttons for the filters
   */
  $.kalibao.backend.tree.View.prototype.initFilterEvents = function () {
    var self = this;
    this.$branchContainer.find('#save-filters').hide();
    this.$branchContainer.find('[data-toggle]').bootstrapToggle();
    this.$branchContainer.find('.btn-close').off('click').on('click', function(e) {
      e.preventDefault();
      self.$branchContainer.html('');
      return false;
    });
    this.$branchContainer.find('.delete-filter').on('click', function() {
      var line = this.closest('tr');
      var params = $(this).data('params');
      $.post("../branch/delete-filter", params, function(){
        line.remove();
        $.toaster({ priority : 'success', title : 'Enregistré', message : 'Le filtre a été supprimé'})
      })
    });
    this.$branchContainer.find('table input[type=text]').on('change', function () {
      self.$branchContainer.find('#save-filters').show();
    });
    this.$branchContainer.find('#add-filter').on('click', function() {
      var $input = self.$branchContainer.find('#input-attribute-type');
      if ($input.val() ==  '') return;
      var $tbody = $(this).closest('table').find('tbody');
      var attributeType = {
        id:    $input.val().split('|')[0],
        label: $input.val().split('|')[1]
      };
      if ($tbody.find('#attribute-' + attributeType.id).length === 0) {
        var $line = $('<tr id="attribute-' + attributeType.id + '"><td>' + attributeType.label + '</td><td><input class="form-control input-sm" type="text" value="' + attributeType.label + '"></td></tr>')
        $tbody.append($line);
        $line.find('input').select();
        self.$branchContainer.find('#save-filters').show();
      }
    });
    this.$branchContainer.find('#save-filters').on('click', function() {
      var $btn = $(this);
      var $new = $(this).closest('table').find('tbody tr:not(.saved)');
      var $old = $(this).closest('table').find('tbody tr.saved');
      var insert = [];
      var update = [];
      $new.each(function() {
        var id     = $(this).attr('id').split('-')[1];
        var i18n   = $(this).find('input').val();
        var branch = $btn.data('branch');
        insert.push({id: id, i18n: i18n, branch: branch});
      });
      $old.each(function() {
        var id     = $(this).attr('id').split('-')[1];
        var i18n   = $(this).find('input').val();
        var branch = $btn.data('branch');
        update.push({id: id, i18n: i18n, branch: branch});
      });
      $.post('../branch/add-filter', {insert: insert, update: update}, function(){
        self.$branchContainer.find('#save-filters').hide();
        $.toaster({ priority : 'success', title : 'Enregistré', message : 'Les filtres ont été enregistrés'})
      });
    });
  };

  /**
   * returns the value of the url parameter (similar to $_GET() in php)
   * @param name string The param name
   * @returns {*} The value of the url param
   */
  $.kalibao.backend.tree.View.prototype.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
      return null;
    }
    else{
      return results[1] || 0;
    }
  };
})(jQuery);
