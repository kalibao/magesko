/**
 * Message component
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.message = $.kalibao.backend.message || {};

  /**
   * Message component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.message.Message = function (args) {
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
  $.kalibao.backend.message.Message.prototype = Object.create($.kalibao.backend.crud.ListGrid.prototype);


  /**
   * Init events
   */
  $.kalibao.backend.message.Message.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initGroupLanguageFormEvent();
    this.initAdvancedFiltersEvents();
    this.initHeadTitlesEvents();
    this.initHeadFiltersEvents();
    this.initPageEvents();
    this.initCheckAllRowsEvents();
    this.initDeleteAllRowsEvent();
    this.initTranslateEvents();
    this.initDeleteRowsEvents(this.$gridBody);
    this.initRowActionsEvents(this.$gridBody);
    this.initSelectRowEvents(this.$gridBody);
    this.initAdvancedDropDownList(this.$gridBody);
  };

  /**
   * Submit advanced filters
   */
  $.kalibao.backend.message.Message.prototype.submitAdvancedFilters = function () {
    var self = this;

    if (!this.validate(this.activeValidators.advancedFilters, this.$advancedFilter)) {
      var action = self.$advancedFilter.find('form').attr('action');
      var params = $.kalibao.core.tools.removeEmptyStringSerialized(self.$advancedFilter.find('input[value!=""], select').serialize());
      params += (params != '') ? '&' : '';
      params += $.kalibao.core.tools.removeEmptyStringSerialized(self.$action.find('.form-group-language').serialize());
      this.loadDataGrid(action, params);
    }
  };

  /**
   * Submit head filters
   */
  $.kalibao.backend.message.Message.prototype.submitHeadFilters = function () {
    var self = this;

    if (!this.validate(this.activeValidators.gridHeadFilters, this.$gridHeadFilter)) {
      var action = self.$gridHeadFilter.find('.btn-search').attr('href');
      var params = $.kalibao.core.tools.removeEmptyStringSerialized(self.$gridHeadFilter.find('input[value!=""], select').serialize());
      params += (params != '') ? '&' : '';
      params += $.kalibao.core.tools.removeEmptyStringSerialized(self.$action.find('.form-group-language').serialize());
      this.loadDataGrid(action, params);
    }
  };

  /**
   * Init group language form event
   */
  $.kalibao.backend.message.Message.prototype.initGroupLanguageFormEvent = function () {
    var self = this;

    this.$action.find('.form-group-language').on('change', function () {
      var $this = $(this);
      var action = $this.attr('action');
      var params = $this.serialize();

      self.$container.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          var $content = $(json.html);
          self.$wrapper.html($content);
          self.saveRequest(action, params);
          if (self.activeScrollAuto) {
            $.kalibao.core.app.scrollTop();
          }
          self.$container.unblock();
        },
        'GET',
        params,
        'JSON',
        true
      );

    });
  };

  /**
   * Init translate events
   */
  $.kalibao.backend.message.Message.prototype.initTranslateEvents = function () {
    var self = this;

    this.$main.find('.btn-translate-all').on('click', function () {
      var action = $(this).attr('href');
      var params = self.$gridBody.find('input, textarea').serialize();

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

      return false;
    });
  };

})(jQuery);