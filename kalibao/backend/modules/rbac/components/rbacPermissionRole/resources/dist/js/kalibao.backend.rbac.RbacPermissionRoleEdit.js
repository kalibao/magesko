/**
 * RbacPermissionRoleEdit component
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao = $.kalibao || {};
  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.rbac = $.kalibao.backend.rbac || {};

  /**
   * RbacUserRole component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Interface id
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.id = null;

  /**
   * BlockUI options
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.blockUIOptions = $.extend($.kalibao.core.app.defaultBlockUI, {});

  /**
   * Scroll auto
   * @type {boolean}
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.activeScrollAuto = true;

  /**
   * {{jQuery}} Wrapper
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.$wrapper;

  /**
   * {{jQuery}} Container
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.$container;

  /**
   * {{jQuery}} Dynamic container
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.$dynamic;

  /**
   * {{jQuery}} Main container
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.$main;

  /**
   * Init object
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.init = function () {
    var self = this;
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.initComponents();
    this.initEvents();
    $.kalibao.core.app.hasUnsavedChanges = function() {
      var changes = false;
      $('form:not(.nocheck)').each(function(){
        if (self.checkFormState(this, true)) changes = true;
        else self.resetFormState(this);
      });
      return changes
    };
  };

  /**
   * Init components
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.initComponents = function () {
  };

  /**
   * Init events
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.initEvents = function () {
    this.initFormReset();
    this.initFormChange();
    this.initActionsEvents();
  };

  /**
   * Init actions events
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.initActionsEvents = function () {
    var self = this;

    this.$main.find('.btn-submit').on('click', function() {
      self.submit();
      return false;
    });
  };

  /**
   * Submit
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.submit = function () {
    var self = this;

    var $form = self.$main.find('form');
    var action = $form.attr('action');
    var params = $form.serialize();

    self.$container.block(self.blockUIOptions);

    $.kalibao.core.app.ajaxQuery(
      action,
      function (json) {
        var $content = $(json.html);
        self.$wrapper.html($content);
        if (self.activeScrollAuto) {
          $.kalibao.core.app.scrollTop();
        }
        self.$container.unblock();
      },
      'POST',
      params,
      'JSON',
      true
    );
  };

  /**
   * Init the buttons to reset the form into their original state
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.initFormReset = function() {
    var self = this;
    this.$container.find('.reset-form').off('click').click(function(e){
      e.preventDefault();
      self.resetFormState(self.$container.find('form'));
      return false;
    });
    this.$container.find('.btn-close').click(function(){
      self.resetFormState(self.$container.find('form'));
    })
  };

  /**
   * Init the events for unsaved data warning before changing page or product tab
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.initFormChange = function() {
    var self = this;
    //sync ckeditors with textareas to catch the change event

    this.$container.find('form').each(function(){
      self.saveFormState(this)
    });

    for (var i in CKEDITOR.instances) {
      CKEDITOR.instances[i].on('change', function() {this.updateElement(); $(this.element.$).change()});
    }
    $(':input').change(function(){
      var $e = $(this);
      var $form = $e.closest('form');
      if (self.checkFormState($form)) {
        $form.find('.btn-submit').removeClass('btn-default disabled').addClass('btn-primary');
      }
      else {
        $form.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
      }
    });
  };

  /**
   * save the current state of the form in memory for later checks /!\ this function does not save data in database
   * @param form the container of the form
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.saveFormState  = function(form) {
    var $form = $(form);
    $form.find(':input:not(:button)').each(function(i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) $input.data('initialState', $input.is(':checked'));
      else $input.data('initialState', $input.val());
    });
    $('.unsaved').removeClass('unsaved');
    $form.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
  };

  /**
   * reverts all changes made on the form since last save
   * @param form the container of the form
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.resetFormState = function(form) {
    var $form = $(form);
    $form.find(':input:not(:button)').each(function(i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) $input.prop('checked', $input.data('initialState'));
      else $input.val($input.data('initialState'));
      $input.removeClass('unsaved');
    });
    // reload select 2 data from hidden input
    $form.find('input.input-ajax-select').each(function(){
      $(this).trigger('change');
    });
    $form.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
  };

  /**
   * checks if the form of the given tab contains unsaved data
   * @param form the container of the form
   * @param notify if set to true, add a class to the unsaved elements
   * @returns {boolean} true : unsaved data, false : no unsaved data
   */
  $.kalibao.backend.rbac.RbacPermissionRoleEdit.prototype.checkFormState = function(form, notify) {
    // set default value
    notify = typeof notify !== 'undefined' ? notify : false;

    var changed = false;
    var $form = $(form);
    $form.find(':input:not(:button)').each(function(i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) {
        if ($input.is(':checked') != $input.data('initialState')) {
          if (notify) {
            $input.removeClass('unsaved');
            setTimeout(function(){$input.addClass('unsaved');}, 1); // setTimeout to restart animation
          }
          changed = true;
        }
      } else {
        if ($input.val() != $input.data('initialState')) {
          if (notify) {
            $input.removeClass('unsaved');
            setTimeout(function(){$input.addClass('unsaved');}, 1); // setTimeout to restart animation
          }
          changed = true;
        }
      }
    });
    return changed;
  };

})(jQuery);