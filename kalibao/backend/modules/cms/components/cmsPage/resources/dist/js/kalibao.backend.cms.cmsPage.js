/**
 * CmsPageEdit component
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
   * CmsPageEdit component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.cms.CmsPageEdit = function (args) {
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
  $.kalibao.backend.cms.CmsPageEdit.prototype = Object.create($.kalibao.backend.crud.Edit.prototype);

  /**
   * Init events
   */
  $.kalibao.backend.cms.CmsPageEdit.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initInputsEvents();
    this.initPageContentsEvents();
  };

  /**
   * Init inputs events
   */
  $.kalibao.backend.cms.CmsPageEdit.prototype.initInputsEvents = function () {
    var self = this;

    this.$main.find('input.active-slug').on('keyup', function(e) {
      var $this = $(this);
      if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
        $this.val($.kalibao.backend.cms.cmsPage.strToSlug($this.val()));
      }
    });

    this.$main.find('.btn-refresh').on('click', function() {
      var $this = $(this);
      var action = $this.attr('href');
      var params = '';

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              var $cacheResults = $this.nextAll('.cache-result');
              if ($cacheResults.length > 0) {
                $cacheResults.remove();
              }
              $this.after(json.html);
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
  };

  /**
   * Init page contents events
   */
  $.kalibao.backend.cms.CmsPageEdit.prototype.initPageContentsEvents = function () {
    var self = this;

    this.$main.find('.input-ajax-select-layout').on('change', function() {
      var $this = $(this);
      var layoutId = $this.val();
      if (layoutId != '') {
        var executeRequest = function (async) {
          $.kalibao.core.app.ajaxQuery(
            $this.attr('data-url-page-contents'),
            function (json) {
              var $content = $(json.html);
              var pageContents = self.$main.find('.page-contents');
              if (pageContents.length > 0) {
                pageContents.remove();
              }
              self.$container.unblock();
              self.$main.find('.html_keywords').after($content);
              self.initWysiwig($content);
            },
            'GET',
            'pageId=' + $this.attr('data-page-id') + '&layoutId=' + $this.val(),
            'JSON',
            async
          );
        };

        self.$container.block(self.blockUIOptions);
        executeRequest(true);
      }
    });

  };

})(jQuery);