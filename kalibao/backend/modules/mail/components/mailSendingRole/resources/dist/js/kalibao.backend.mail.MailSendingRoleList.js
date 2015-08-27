/**
 * MailSendingRoleList component
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.mail = $.kalibao.backend.mail || {};

  /**
   * MailSendingRoleList component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.mail.MailSendingRoleList = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.backend.crud.ListGrid}
   */
  $.kalibao.backend.mail.MailSendingRoleList.prototype = Object.create($.kalibao.backend.crud.ListGrid.prototype);


  /**
   * Init row actions events
   */
  $.kalibao.backend.mail.MailSendingRoleList.prototype.initRowActionsEvents = function ($container) {
    var self = this;

    $container.find('.btn-edit-row').on('click', function () {
      self.editRow($(this).closest('tr'));
      return false;
    });
  };

  /**
   * Init actions events
   */
  $.kalibao.backend.mail.MailSendingRoleList.prototype.initActionsEvents = function () {
    var self = this;

    this.$action.find('.btn-create, .btn-settings').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      self.$wrapper.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          self.$main.remove();
          var $content = $(json.html);
          self.$dynamic.html($content);
          self.saveDynamicBackLink();
          self.$wrapper.unblock();
        },
        'GET',
        params,
        'JSON',
        true
      );

      return false;
    });
  };

  /**
   * Load data grid
   * @param {string} action Request Url
   * @param {string} params Request parameters
   */
  $.kalibao.backend.mail.MailSendingRoleList.prototype.loadDataGrid = function(action, params) {
    var self = this;

    this.$wrapper.block(self.blockUIOptions);

    $.kalibao.core.app.ajaxQuery(
      action,
      function (json) {
        var $content = $(json.html);
        self.$wrapper.html($content);
        self.$wrapper.unblock();
      },
      'GET',
      params,
      'JSON',
      true
    );
  };

})(jQuery);