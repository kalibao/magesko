/**
 * Setting component of crud
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao = $.kalibao || {};
  $.kalibao.crud = $.kalibao.crud || {};

  /**
   * Setting component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.crud.Setting = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Interface id
   */
  $.kalibao.crud.Setting.prototype.id = null;

  /**
   * Messages
   * @type {{}}
   */
  $.kalibao.crud.Setting.prototype.messages = $.kalibao.core.app.messages;

  /**
   * BlockUI options
   */
  $.kalibao.crud.Setting.prototype.blockUIOptions = $.extend($.kalibao.core.app.defaultBlockUI, {});

  /**
   * Scroll auto
   * @type {boolean}
   */
  $.kalibao.crud.Setting.prototype.activeScrollAuto = true;

  /**
   * {{jQuery}} Wrapper
   */
  $.kalibao.crud.Setting.prototype.$wrapper;

  /**
   * {{jQuery}} Container
   */
  $.kalibao.crud.Setting.prototype.$container;

  /**
   * {{jQuery}} Dynamic container
   */
  $.kalibao.crud.Setting.prototype.$dynamic;

  /**
   * {{jQuery}} Main container
   */
  $.kalibao.crud.Setting.prototype.$main;

  /**
   * Active validators
   * @type {{}}
   */
  $.kalibao.crud.Setting.prototype.activeValidators = {};

  /**
   * Validators
   * @type {Array}
   */
  $.kalibao.crud.Setting.prototype.validators = [];

  /**
   * Init object
   */
  $.kalibao.crud.Setting.prototype.init = function () {
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.initComponents();
    this.initEvents();
  };

  /**
   * Init components
   */
  $.kalibao.crud.Setting.prototype.initComponents = function () {
    this.initValidators(this.validators, this.activeValidators);
    this.initAdvancedDropDownList(this.$main);
    this.initDatePicker(this.$main);
  };

  /**
   * Init events
   */
  $.kalibao.crud.Setting.prototype.initEvents = function () {
    this.initActionsEvents();
  };

  /**
   * Init actions events
   */
  $.kalibao.crud.Setting.prototype.initActionsEvents = function () {
    var self = this;

    this.$main.find('.btn-submit').on('click', function() {
      self.submit();
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
  $.kalibao.crud.Setting.prototype.submit = function () {
    var self = this;

    if (! this.validate(this.activeValidators, this.$main)) {
      var action = self.$main.find('form').attr('action');
      var params = self.$main.find('input[value!=""], select, textarea').serialize();

      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          action,
          function (json) {
            if (json.loginReload) {

            } else {
              var $content = $(json.html);
              self.$wrapper.html($content);
              if (self.activeScrollAuto) {
                $.kalibao.core.app.scrollTop();
              }
            }
            self.$container.unblock();
          },
          'POST',
          params,
          'JSON',
          async
        );
      };

      self.$container.block(self.blockUIOptions);
      executeRequest(true);
    }
  };

  /**
   * Get back link
   * The function return an object containing action and target or false
   * @returns {*}
   */
  $.kalibao.crud.Setting.prototype.getDynamicBackLink = function () {
    if (this.$wrapper.length > 0) {
      var result = {
        action: undefined,
        params: undefined,
        target: undefined
      };
      var action = this.$wrapper.attr('data-back-action');
      var params = this.$wrapper.attr('data-back-params');
      var target = this.$wrapper.attr('data-back-target');
      if (action !== undefined && params !== undefined && target !== undefined) {
        result.action = action;
        result.params = params;
        result.target = target;
        return result;
      }
    }
    return false;
  };

  /**
   * Save dynamic back link
   */
  $.kalibao.crud.Setting.prototype.saveDynamicBackLink = function () {
    this.$dynamic.attr('data-back-action', this.$wrapper.attr('data-action') || window.location.href || '');
    this.$dynamic.attr('data-back-params', this.$wrapper.attr('data-params') || '');
    this.$dynamic.attr('data-back-target', this.id);
  };

  /**
   * Save request
   * @param string action Request url
   * @param string params Request parameters
   */
  $.kalibao.crud.Setting.prototype.saveRequest = function (action, params)
  {
    $.kalibao.core.app.changeUrl(action, params);
    this.$wrapper.attr('data-action', action);
    this.$wrapper.attr('data-params', params);
  };

  /**
   * Init advanced drop down list component
   * @param {{jQuery}} $container
   */
  $.kalibao.crud.Setting.prototype.initAdvancedDropDownList = function ($container) {
    var self = this;
    $container.find('.input-ajax-select').each(function () {
      $.kalibao.crud.tools.initAdvancedDropDownList($(this));
    });
  };

  /**
   * Init date picker
   * @param {{jQuery}} $component
   */
  $.kalibao.crud.Setting.prototype.initDatePicker = function ($container) {
    $container.find('.date-picker').datepicker($.extend(
      $.kalibao.core.app.datePickerLanguage,
      {dateFormat: 'yy-mm-dd'}
    ));
  };

  /**
   * Init validators
   * @param {{}} source
   * @param {{}} destination
   */
  $.kalibao.crud.Setting.prototype.initValidators = function (source, destination) {
    for (var attribute in source) {
      destination[attribute] = {
        id: source[attribute].id,
        script: []
      };

      for (var id in source[attribute].js) {
        destination[attribute].script.push(new Function(
          'attribute', 'value', 'messages', source[attribute].js[id]
        ));
      }
    }
  };

  /**
   * Validate input in a container
   * @param {{}} validators List of validators
   * @param {{jQuery}} $container jQuery container
   * @returns {boolean}
   */
  $.kalibao.crud.Setting.prototype.validate = function(validators, $container) {
    var hasError = false;

    // clean
    $container.find('.form-group.has-error').removeClass('has-error');
    $container.find('.help-inline').html('');

    for (var attribute in validators) {
      var id = validators[attribute].id;
      for (var i in validators[attribute].script) {
        var messages = [];
        var $input = $container.find('input[data-validator-id=' + id + '], textarea[data-validator-id=' + id + '], select[data-validator-id=' + id + ']');
        var $formGroup = $input.closest('.form-group');
        var $helpInline = $input.next('.help-inline');

        // validate
        validators[attribute].script[i](attribute, $input.val(), messages);

        // display messages
        if (messages.length > 0) {
          hasError = true;
          $formGroup.addClass('has-error');
          for (var j in messages) {
            $helpInline.html(messages[j]);
          }
        }
      }
    }

    return hasError;
  };

})(jQuery);