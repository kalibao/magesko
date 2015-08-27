/**
 * Created by stagiaire on 13/05/15.
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.client = $.kalibao.backend.client || {};

  /**
   * AddressSetting component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.client.AddressSetting = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.backend.crud.Setting}
   */
  $.kalibao.backend.client.AddressSetting.prototype = Object.create($.kalibao.backend.crud.Setting.prototype);

  /**
   * Init actions events
   */
  $.kalibao.backend.client.AddressSetting.prototype.initActionsEvents = function () {
    var self = this;
    this.$main.find('.btn-submit').on('click', function() {
      self.submit();
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