/**
 * CmsPageTranslate component
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
   * CmsPageTranslate component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.cms.CmsPageTranslate = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.backend.crud.Translate}
   */
  $.kalibao.backend.cms.CmsPageTranslate.prototype = Object.create($.kalibao.backend.crud.Translate.prototype);

  /**
   * Init events
   */
  $.kalibao.backend.cms.CmsPageTranslate.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initGroupLanguageFormEvent();
    this.initInputsEvents();
  };

  /**
   * Init inputs events
   */
  $.kalibao.backend.cms.CmsPageTranslate.prototype.initInputsEvents = function () {
    this.$main.find('input.active-slug').on('keyup', function(e) {
      var $this = $(this);
      if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
        $this.val($.kalibao.backend.cms.cmsPage.strToSlug($this.val()));
      }
    });
  };

})(jQuery);