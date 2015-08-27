/**
 * CmsSimpleMenuGroupList component
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.cms = $.kalibao.backend.cms || {};

  /**
   * CmsSimpleMenuGroupList component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.cms.CmsSimpleMenuGroupList = function (args) {
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
  $.kalibao.backend.cms.CmsSimpleMenuGroupList.prototype = Object.create($.kalibao.backend.crud.ListGrid.prototype);

  /**
   * Init row actions events
   */
  $.kalibao.backend.cms.CmsSimpleMenuGroupList.prototype.initRowActionsEvents = function ($container) {
    var self = this;

    $container.find('.btn-edit-row').on('click', function () {
      self.editRow($(this).closest('tr'));
      return false;
    });

    $container.find('.btn-translate').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      self.$wrapper.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          self.$main.remove();
          $('title').html(json.title);
          var $content = $(json.html);
          self.$dynamic.html($content);
          self.saveDynamicBackLink();
          $.kalibao.core.app.changeUrl(action, params);
          if (self.activeScrollAuto) {
            $.kalibao.core.app.scrollTop();
          }
          self.$wrapper.unblock();
        },
        'GET',
        params,
        'JSON',
        true
      );

      return false;
    });

    $container.find('.btn-list-menu').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      self.$wrapper.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          var $content = $('<div class="content-dynamic"></div>');
          $content.attr('data-action', action);
          $content.attr('data-params', params);

          var modal = new $.kalibao.core.Modal({
            id: 'modal-auto-' + (new Date().getTime()),
            options: 'data-backdrop="static"'
          });
          modal.$component.find('.modal-dialog').addClass('modal-lg');
          modal.setBody($content);

          $content.html(json.html);
          modal.open();

          $content.on('click', '.btn-close', function () {
            modal.close();
            return false;
          });
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
  $.kalibao.backend.cms.CmsSimpleMenuGroupList.prototype.loadDataGrid = function(action, params) {
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