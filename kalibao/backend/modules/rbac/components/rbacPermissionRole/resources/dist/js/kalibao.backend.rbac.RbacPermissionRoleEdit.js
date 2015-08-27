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
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.initComponents();
    this.initEvents();
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

})(jQuery);