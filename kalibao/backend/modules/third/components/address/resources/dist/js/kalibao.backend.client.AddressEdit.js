/**
 * Created by stagiaire on 13/05/15.
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.client = $.kalibao.backend.client || {};

  /**
   * MailSendingRoleEdit component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.client.AddressEdit = function (args) {
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
  $.kalibao.backend.client.AddressEdit.prototype = Object.create($.kalibao.backend.crud.Edit.prototype);

  /**
   * Init actions events
   */
  $.kalibao.backend.client.AddressEdit.prototype.initActionsEvents = function () {
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
      var action = $('#Address').attr('data-href');
      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          $('#Address').html($(json.html));
        },
        'GET', '', 'JSON', true
      );
      return false;
    });
  };
})(jQuery);