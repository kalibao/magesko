/**
 * CmsSimpleMenuTranslate component
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
   * CmsSimpleMenuTranslate component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.cms.CmsSimpleMenuTranslate = function (args) {
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
  $.kalibao.backend.cms.CmsSimpleMenuTranslate.prototype = Object.create($.kalibao.backend.crud.Translate.prototype);


  /**
   * Init row actions events
   */
  $.kalibao.backend.cms.CmsSimpleMenuTranslate.prototype.initRowActionsEvents = function ($container) {
    var self = this;

    $container.find('.btn-edit-row').on('click', function () {
      self.editRow($(this).closest('tr'));
      return false;
    });
  };

  /**
   * Init actions events
   */
  $.kalibao.backend.cms.CmsSimpleMenuTranslate.prototype.initActionsEvents = function () {
    var self = this;

    this.$main.find('.btn-submit').on('click', function() {
      self.submit();
      return false;
    });

    this.$main.find('.btn-close').on('click', function() {
      var backLink = self.getDynamicBackLink();
      var action = '';
      var params = '';
      var $wrapper = null;

      if (backLink !== false) {
        action = backLink.action;
        params = backLink.params;
        $wrapper = $('#' + backLink.target).parent('.content-dynamic');
      } else {
        var $this = $(this);
        action = $this.attr('href');
        $wrapper = self.$wrapper;
      }

      self.$container.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          var $content = $(json.html);
          $wrapper.html($content);
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
   * Init group language form event
   */
  $.kalibao.backend.cms.CmsSimpleMenuTranslate.prototype.initGroupLanguageFormEvent = function () {
    var self = this;

    this.$main.find('.form-group-language').on('change', function () {
      var $this = $(this);
      var action = $this.attr('action');
      var params = $this.serialize();

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              var $content = $(json.html);
              self.$wrapper.html($content);
            }
            self.$container.unblock();
          },
          'GET',
          params,
          'JSON',
          async
        );
      };

      self.$container.block(self.blockUIOptions);
      executeRequest(true);
    });
  };

  /**
   * Submit
   */
  $.kalibao.backend.cms.CmsSimpleMenuTranslate.prototype.submit = function () {
    var self = this;

    if (!this.validate(this.activeValidators, this.$main)) {
      var form = self.$main.find('form.form-translate');
      var action = form.attr('action');
      var params = form.find('input, select, textarea').serialize();

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              var $content = $(json.html);
              self.$wrapper.html($content);
            }
            self.$container.unblock();
          },
          'POST',
          params,
          'JSON',
          async
        );
      };

      self.$container.block(self.blockUIOptions);
      executeRequest(true);
    }
  };

})(jQuery);