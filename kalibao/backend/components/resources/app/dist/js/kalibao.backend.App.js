/**
 * Backend application component
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao = $.kalibao || {};
  $.kalibao.backend = $.kalibao.backend || {};

  /**
   * Application component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.App = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Init
   */
  $.kalibao.backend.App.prototype.init = function () {
    this.disableAppOnOlderBrowser();
    this.initChangeLanguageEvent();
    this.initSideBarEvent();
    this.initHeaderMenuEvent();
  };

  $.kalibao.backend.App.prototype.blockUIOptions = $.extend($.kalibao.core.app.defaultBlockUI, {});

  /**
   * Disable application on older browser
   */
  $.kalibao.backend.App.prototype.disableAppOnOlderBrowser = function () {
    var isIE = $.kalibao.core.tools.isIE();
    if (isIE !== false && isIE < 10) {
      var $html = $('<div class="browser-compatibility">' + $.kalibao.core.app.messages.kalibao.browser_compatibility_error_ie10 + '</div>');
      var $body = $('body');
      var $wrapper = $body.find('.wrapper');
      $('html').css('height', '100%');
      $body.css('height', '100%');
      $wrapper.css('height', '100%');
      $wrapper.html($html);
    }
  };

  /**
   * Save request
   * @param {string} action Request url
   * @param {string} params Request parameters
   */
  $.kalibao.backend.App.prototype.saveRequest = function ($wrapper, action, params)
  {
    $.kalibao.core.app.changeUrl(action, params);
    $wrapper.attr('data-action', action);
    $wrapper.attr('data-params', params);
    $wrapper.attr('data-open-advanced-filters', 0);
  };

  /**
   * Change language action
   */
  $.kalibao.backend.App.prototype.initChangeLanguageEvent = function ()
  {
    $('form.current-language').on('change', 'select.language-selector', function () {
      $(this).closest('form').submit();
    });
  };

  /**
   * Init header menu event
   */
  $.kalibao.backend.App.prototype.initHeaderMenuEvent = function () {
    var self = this;
    var $container = $('.content-wrapper > .content-dynamic');
    var $headerMenu =  $('.navbar');

    var links = $headerMenu.find('a[href!=#].ajax-link');

    links.on('click', function () {
      var $this = $(this);
      var action = $this.attr('href');
      var params = '';

      $headerMenu.find('.dropdown.user-menu').removeClass('open');

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              $('title').html(json.title);
              self.saveRequest($container, action, params);
              var $content = $(json.html);
              $container.html($content);
              $.kalibao.core.app.scrollTop();
            }
            $container.unblock();
          },
          'GET',
          params,
          'JSON',
          async
        );
      };

      $container.block(self.blockUIOptions);
      executeRequest(true);

      return false;
    });
  };

  /**
   * Init side bar
   */
  $.kalibao.backend.App.prototype.initSideBarEvent = function () {
    var self = this;
    var $container = $('.content-wrapper > .content-dynamic');
    var $sideBarMenu =  $('.sidebar-menu');
    var locationPathName = window.location.pathname;

    var links = $sideBarMenu.find('a[href!=#]');
    links.each(function () {
      var $this = $(this);
      if ($this.attr('href') == locationPathName) {
        $sideBarMenu.find('li.active').removeClass('active');
        $this.closest('li').addClass('active');
        $this.closest('.treeview').addClass('active');
      }
    });

    links.on('click', function () {
      var $this = $(this);
      var action = $this.attr('href');
      var params = '';

      $sideBarMenu.find('li.active').removeClass('active');
      $this.closest('li').addClass('active');
      $this.closest('.treeview').addClass('active');

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              $('title').html(json.title);
              self.saveRequest($container, action, params);
              var $content = $(json.html);
              $container.html($content);
              $.kalibao.core.app.scrollTop();
            }
            $container.unblock();
          },
          'GET',
          params,
          'JSON',
          async
        );
      };

      $container.block(self.blockUIOptions);
      executeRequest(true);

      return false;
    });
  };

})(jQuery);