/**
 * thirdSendingRoleEdit component
 *
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.third = $.kalibao.backend.third || {};

  /**
   * third component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.third.ThirdEdit = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();

    this.$address = $('.tab-pane#Address');
    this.initAddress();
  };

  /**
   * Extend class
   * @type {$.kalibao.backend.crud.Edit}
   */
  $.kalibao.backend.third.ThirdEdit.prototype = Object.create($.kalibao.backend.crud.Edit.prototype);

  /**
   * Init actions events
   */
  $.kalibao.backend.third.ThirdEdit.prototype.initActionsEvents = function () {
    var self = this;

    this.$main.find('.btn-submit').on('click', function() {
      self.submit($(this));
      return false;
    });

    this.$main.find('.btn-add-again').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      self.$wrapper.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          $('title').html(json.title);
          var $content = $(json.html);
          self.$wrapper.html($content);
          self.saveRequest(action, params);
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
          $('title').html(json.title);
          var $content = $(json.html);
          $wrapper.html($content);
          $.kalibao.core.app.changeUrl(action, params);
          if (self.activeScrollAuto) {
            $.kalibao.core.app.scrollTop();
          }
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
  $.kalibao.backend.third.ThirdEdit.prototype.submit = function ($button) {
    var self = this;

    if (window.FormData && ! this.validate(this.activeValidators, this.$main)) {
      var $form = $button.closest('form');
      var action = $form.attr('action');
      var params = new FormData();

      $form.find('input, select, textarea').each(function () {
        var $input = $(this);
        if ($input.attr('name') !== undefined) {
          var inputType = $input.attr('type');
          if (inputType === 'file') {
            if ($input.get(0).files.length > 0) {
              params.append($input.attr('name'), $input.get(0).files[0]);
            }
          } else if(inputType === 'checkbox') {
            if ($input.is(':checked')) {
              params.append($input.attr('name'), $input.val());
            }
          } else {
            params.append($input.attr('name'), $input.val());
          }
        }
      });

      self.$container.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          self.$container.unblock();
        },
        'POST',
        params,
        'JSON',
        true
      );
    }
  };

  /**
   * Init address
   */
  $.kalibao.backend.third.ThirdEdit.prototype.initAddress = function () {
    var self = this;
    var action = self.$address.attr('data-href');
    $.kalibao.core.app.ajaxQuery(
      action,
      function (json) {
        self.$address.html($(json.html));
      },
      'GET', '', 'JSON', true
    );
    return false;
  };

})(jQuery);