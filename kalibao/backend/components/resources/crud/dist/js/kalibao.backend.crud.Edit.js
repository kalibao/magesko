/**
 * Edit component of crud
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.crud = $.kalibao.backend.crud || {};

  /**
   * Edit component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.crud.Edit = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.crud.Edit}
   */
  $.kalibao.backend.crud.Edit.prototype = Object.create($.kalibao.crud.Edit.prototype);

})(jQuery);