/**
 * CmsSimpleMenuEdit component
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
   * MailSendingRoleEdit component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.cms.CmsSimpleMenuEdit = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.backend.crud.Edit}
   */
  $.kalibao.backend.cms.CmsSimpleMenuEdit.prototype = Object.create($.kalibao.backend.crud.Edit.prototype);

  /**
   * Init actions events
   */
  $.kalibao.backend.cms.CmsSimpleMenuEdit.prototype.initActionsEvents = function () {
    var self = this;

    this.$main.find('.btn-submit').on('click', function() {
      self.submit();
      return false;
    });

    this.$main.find('.btn-add-again').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      self.$wrapper.block(self.blockUIOptions);

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
        if ($wrapper.parent('.modal-body').length > 0) {
          return true;
        }
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
   * Submit
   */
  $.kalibao.backend.cms.CmsSimpleMenuEdit.prototype.submit = function () {
    var self = this;

    if (window.FormData && ! this.validate(this.activeValidators, this.$main)) {
      var $form = self.$main.find('form');
      var action = $form.attr('action');
      var params = new FormData($form[0]);

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