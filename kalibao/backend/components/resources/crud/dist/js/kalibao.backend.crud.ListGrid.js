/**
 * List component of crud
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
   * ListGrid component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.crud.ListGrid = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.crud.ListGrid}
   */
  $.kalibao.backend.crud.ListGrid.prototype = Object.create($.kalibao.crud.ListGrid.prototype);

  /**
   * Init head filters events
   */
  $.kalibao.crud.ListGrid.prototype.initHeadFiltersEvents = function () {
    var self = this;

    this.$gridHeadFilter.find('.btn-search').on('click', function () {
      self.submitHeadFilters();
      return false;
    });

    this.$gridHeadFilter.find('input').on('keyup', function (e) {
      if (e.keyCode === 13) {
        self.submitHeadFilters();
      }
      return false;
    });

    this.$gridHeadFilter.find('.delete-search').click(function() {
      if ($(this).siblings('input').val() == '') return;
      $(this).siblings('input').val('');
      $(this).siblings('select').prop('selectedIndex', 0);
      self.$gridHeadFilter.find('.btn-search').click();
    })
  };

})(jQuery);