/**
 * CmsPageList component
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
   * CmsPageList component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.cms.CmsPageList = function (args) {
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
  $.kalibao.backend.cms.CmsPageList.prototype = Object.create($.kalibao.backend.crud.ListGrid.prototype);

  /**
   * Init actions events
   */
  $.kalibao.backend.cms.CmsPageList.prototype.initActionsEvents = function () {
    var self = this;

    this.$action.find('.btn-refresh-all').on('click', function() {
      var $this = $(this);
      var action = $this.attr('href');
      var params = '';

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              var $cacheResults = self.$grid.prevAll('.cache-result');
              if ($cacheResults.length > 0) {
                $cacheResults.remove();
              }
              self.$grid.before(json.html);
            }
            self.$wrapper.unblock();
          },
          'POST',
          params,
          'JSON',
          async
        );
      };

      self.$wrapper.block(self.blockUIOptions);
      executeRequest(true);

      return false;
    });

    this.$action.find('.btn-create, .btn-settings').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              self.$main.remove();
              $('title').html(json.title);
              var $content = $(json.html);
              self.$dynamic.html($content);
              self.saveDynamicBackLink();
              $.kalibao.core.app.changeUrl(action, params);
              if (self.activeScrollAuto) {
                $.kalibao.core.app.scrollTop();
              }
            }
            self.$wrapper.unblock();
          },
          'GET',
          params,
          'JSON',
          async
        );
      };

      self.$wrapper.block(self.blockUIOptions);
      executeRequest(true);

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
  $.kalibao.backend.cms.CmsPageList.prototype.initRowEditEvents = function ($container) {
    var self = this;

    $container.find('input').on('keyup', function (e) {
      if (e.keyCode === 13) {
        $container.find('.btn-update-row').click();
      }
      return false;
    });

    $container.find('input.active-slug').on('keyup', function(e) {
      var $this = $(this);
      if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
        $this.val($.kalibao.backend.cms.cmsPage.strToSlug($this.val()));
      }
    });

    $container.find('.btn-close-row').on('click', function () {
      var $this = $(this);
      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          $this.attr('href'),
          function (json) {
            if (json.loginReload) {

            } else {
              var $content = $(json.html);
              $this.closest('tr').replaceWith($content)
              self.initRowActionsEvents($content);
              self.initSelectRowEvents($content);
              self.initDeleteRowsEvents($content);
              self.$wrapper.unblock();
            }
          },
          'GET',
          '',
          'JSON',
          async
        );
      };

      self.$wrapper.block(self.blockUIOptions);
      executeRequest(true);

      return false;
    });

    $container.find('.btn-update-row').on('click', function () {
      var $this = $(this);
      var $tr = $this.closest('tr');

      if (window.FormData && ! self.validate(self.activeValidators.gridRowEdit, $tr)) {
        var action = $this.attr('href');
        var params = new FormData();

        $tr.find('input, select, textarea').each(function () {
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

        var executeRequest = function (async) {
          $.kalibao.core.app.ajaxQuery(
            action,
            function (json) {
              if (json.loginReload) {

              } else {
                var $content = $(json.html);
                $tr.replaceWith($content);
                if (json.saved) {
                  self.initRowActionsEvents($content);
                  self.initSelectRowEvents($content);
                  self.initDeleteRowsEvents($content);
                } else {
                  self.initDatePicker($content);
                  self.initRowEditEvents($content);
                  self.initAdvancedDropDownList($content);
                  self.initWysiwig($content);
                  self.initUploader($content);
                }
                self.$wrapper.unblock();
              }
            },
            'POST',
            params,
            'JSON',
            async
          );
        };

        self.$wrapper.block(self.blockUIOptions);
        executeRequest(true);
      }

      return false;
    });
  };

})(jQuery);