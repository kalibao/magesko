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
  $.kalibao.backend.third.ThirdList = function (args) {
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
  $.kalibao.backend.third.ThirdList.prototype = Object.create($.kalibao.backend.crud.ListGrid.prototype);

  /**
   * Init actions events
   */
  $.kalibao.backend.third.ThirdList.prototype.initActionsEvents = function () {
    var self = this;

    this.$action.find('.btn-create').on('click', function() {
      var $this = $(this);
      var params = $this.attr('data-name') + '=' + encodeURIComponent($this.attr('data-value'));

      var modal = new $.kalibao.core.Modal({id:'modal-create-third'});
      modal.setHeader(self.messages.modal_create_third);
      modal.setBtnPrimary(self.messages.kalibao.btn_confirm);
      modal.setBtnSecondary(self.messages.kalibao.btn_cancel);

      // buttons actions
      modal.$component.find('.btn-secondary, .close').on('click', function () {
        modal.close();
        return false;
      });

      modal.setBody(
        $('<div>').attr('class', 'form-group').append(
          $('<select>').attr({'class': 'form-control', 'id': 'interface-select'}).append(
            $('<option>').attr({'class': 'option', 'value': 'person'}).html(self.messages.modal_select_person)
          ).append(
            $('<option>').attr({'class': 'option', 'value': 'company'}).html(self.messages.modal_select_company)
          )
        )
      );

      modal.$component.find('.btn-primary').on('click', function () {
        var action = '';
        var selectVal = $('#interface-select').val();
        if (selectVal == 'person') {
          action = $('.redirect-third').attr('data-person');
        } else if (selectVal == 'company') {
          action = $('.redirect-third').attr('data-company');
        }
        var params = '';

        self.$wrapper.block(self.blockUIOptions);

        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            modal.close();
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

      modal.open();
      return false;
    });

    this.$action.find('.btn-settings').on('click', function() {
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

    this.$action.find('.btn-advanced-filters').on('click', function () {
      self.$wrapper.attr('data-open-advanced-filters', '1');
      self.$advancedFilter.show();
      return false;
    });
  };
})(jQuery);