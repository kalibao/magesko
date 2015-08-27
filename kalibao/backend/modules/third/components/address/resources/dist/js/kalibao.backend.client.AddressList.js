/**
 * Created by stagiaire on 13/05/15.
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.client = $.kalibao.backend.client || {};

  /**
   * AddressEdit component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.client.AddressList = function (args) {
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
  $.kalibao.backend.client.AddressList.prototype = Object.create($.kalibao.backend.crud.ListGrid.prototype);

  /**
   * Load data grid
   * @param {string} action Request Url
   * @param {string} params Request parameters
   */
  $.kalibao.backend.client.AddressList.prototype.loadDataGrid = function(action, params) {
    var self = this;

    this.$wrapper.block(self.blockUIOptions);

    $.kalibao.core.app.ajaxQuery(
      action,
      function (json) {
        $('title').html(json.title);
        $('#Address').html($(json.html));
        self.saveRequest(action, params);
        self.$wrapper.unblock();
      },
      'GET',
      params,
      'JSON',
      true
    );
  };

  /**
   * Init actions eventsListGrid
   */
  $.kalibao.backend.client.AddressList.prototype.initActionsEvents = function () {
    var self = this;
    this.$action.find('.btn-create, .btn-settings').on('click', function() {
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
          self.$wrapper.unblock();
        },
        'GET',
        params,
        'JSON',
        true
      );

      return false;
    });

    this.$action.find('.btn-advanced-filters').on('click', function () {
      self.$wrapper.attr('data-open-advanced-filters', '1');
      self.$advancedFilter.show();
      return false;
    });
  };

  /**
   * Init row actions events
   */
  $.kalibao.backend.client.AddressList.prototype.initRowActionsEvents = function ($container) {
    var self = this;

    $container.find('.btn-edit-row').on('click', function () {
      self.editRow($(this).closest('tr'));
      return false;
    });

    $container.find('.btn-update, .btn-translate').on('click', function() {
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
})(jQuery);