/**
 * Translate component of crud
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
   * Translate component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.crud.Translate = function (args) {
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
  $.kalibao.crud.Translate.prototype.id = null;

  /**
   * Messages
   * @type {{}}
   */
  $.kalibao.crud.Translate.prototype.messages = $.kalibao.core.app.messages;

  /**
   * BlockUI options
   */
  $.kalibao.crud.Translate.prototype.blockUIOptions = $.extend($.kalibao.core.app.defaultBlockUI, {});

  /**
   * Scroll auto
   * @type {boolean}
   */
  $.kalibao.crud.Translate.prototype.activeScrollAuto = true;

  /**
   * {{jQuery}} Wrapper
   */
  $.kalibao.crud.Translate.prototype.$wrapper;

  /**
   * {{jQuery}} Container
   */
  $.kalibao.crud.Translate.prototype.$container;

  /**
   * {{jQuery}} Dynamic container
   */
  $.kalibao.crud.Translate.prototype.$dynamic;

  /**
   * {{jQuery}} Main container
   */
  $.kalibao.crud.Translate.prototype.$main;

  /**
   * Active validators
   * @type {{}}
   */
  $.kalibao.crud.Translate.prototype.activeValidators = {};

  /**
   * Validators
   * @type {Array}
   */
  $.kalibao.crud.Translate.prototype.validators = [];

  /**
   * Init object
   */
  $.kalibao.crud.Translate.prototype.init = function () {
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
  $.kalibao.crud.Translate.prototype.initComponents = function () {
    this.initValidators(this.validators, this.activeValidators);
    this.initDatePicker(this.$main);
    this.initWysiwig(this.$main);
  };

  /**
   * Init events
   */
  $.kalibao.crud.Translate.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initGroupLanguageFormEvent();
  };

  /**
   * Init group language form event
   */
  $.kalibao.crud.Translate.prototype.initGroupLanguageFormEvent = function () {
    var self = this;

    this.$main.find('.form-group-language').on('change', function () {
      var $this = $(this);
      var action = $this.attr('action');
      var params = $this.serialize();

      self.$container.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          var $content = $(json.html);
          self.$wrapper.html($content);
          self.saveRequest(action, params);
          if (self.activeScrollAuto) {
            $.kalibao.core.app.scrollTop();
          }
          self.$container.unblock();
        },
        'GET',
        params,
        'JSON',
        true
      );

    });
  };

  /**
   * Init actions events
   */
  $.kalibao.crud.Translate.prototype.initActionsEvents = function () {
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
  $.kalibao.crud.Translate.prototype.submit = function () {
    var self = this;

    if (!this.validate(this.activeValidators, this.$main)) {
      var form = self.$main.find('form.form-translate');
      var action = form.attr('action');
      var params = form.find('input, select, textarea').serialize();

      self.$container.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          var $content = $(json.html);
          self.$wrapper.html($content);
          if (self.activeScrollAuto) {
            $.kalibao.core.app.scrollTop();
          }
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
   * Get back link
   * The function return an object containing action and target or false
   * @returns {*}
   */
  $.kalibao.crud.Translate.prototype.getDynamicBackLink = function () {
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
  $.kalibao.crud.Translate.prototype.saveDynamicBackLink = function () {
    this.$dynamic.attr('data-back-action', this.$wrapper.attr('data-action') || window.location.href || '');
    this.$dynamic.attr('data-back-params', this.$wrapper.attr('data-params') || '');
    this.$dynamic.attr('data-back-target', this.id);
  };

  /**
   * Save request
   * @param {string} action Request url
   * @param {string} params Request parameters
   */
  $.kalibao.crud.Translate.prototype.saveRequest = function (action, params)
  {
    $.kalibao.core.app.changeUrl(action, params);
    this.$wrapper.attr('data-action', action);
    this.$wrapper.attr('data-params', params);
  };

  /**
   * Init date picker
   * @param {{jQuery}} $component
   */
  $.kalibao.crud.Translate.prototype.initDatePicker = function ($container) {
    $container.find('.date-picker').datepicker($.extend(
      $.kalibao.core.app.datePickerLanguage,
      {dateFormat: 'yy-mm-dd'}
    ));
  };


  /**
   * Init wysiwyg
   * @param {{jQuery}} $container
   */
  $.kalibao.crud.Translate.prototype.initWysiwig = function ($container)
  {
    $container.find('.wysiwyg-textarea').each(function () {
      var $this = $(this);
      var url = $this.attr('data-ckeditor-filebrowser-browse-url');
      var language = $this.attr('data-ckeditor-language');

      var options = {};
      if (url !== undefined) {
        options.filebrowserBrowseUrl = url;
      }
      if (language !== undefined) {
        options.language = language;
      }

      $this.ckeditor(options);
    });
  };

  /**
   * Init validators
   * @param {{}} source
   * @param {{}} destination
   */
  $.kalibao.crud.Translate.prototype.initValidators = function (source, destination) {
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
  $.kalibao.crud.Translate.prototype.validate = function(validators, $container) {
    var hasError = false;

    // clean
    $container.find('.form-group.has-error').removeClass('has-error');
    $container.find('.help-inline').html('');

    for (var attribute in validators) {
      var id = validators[attribute].id;
      for (var i in validators[attribute].script) {
        var $inputs = $container.find('input[data-validator-id=' + id + '], textarea[data-validator-id=' + id + ']');
        $inputs.each(function () {
          var messages = [];
          var $input = $(this);
          var $formGroup = $input.closest('.form-group');
          var $helpInline = $input.nextAll('.help-inline');

          // validate
          validators[attribute].script[i](attribute, $input.val(), messages);

          // display messages
          if (messages.length > 0) {
            hasError = true;
            $formGroup.addClass('has-error');
            var strMessage = '';
            for (var j in messages) {
              if (messages[j] != '') {
                $helpInline.html(messages[j]);
                break;
              }
            }
          }
        });
      }
    }

    return hasError;
  };

})(jQuery);