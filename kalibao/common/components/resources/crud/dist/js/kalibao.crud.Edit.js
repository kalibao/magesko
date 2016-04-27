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

  $.kalibao = $.kalibao || {};
  $.kalibao.crud = $.kalibao.crud || {};

  /**
   * Edit component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.crud.Edit = function (args) {
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
  $.kalibao.crud.Edit.prototype.id = null;

  /**
   * Messages
   * @type {{}}
   */
  $.kalibao.crud.Edit.prototype.messages = $.kalibao.core.app.messages;

  /**
   * BlockUI options
   */
  $.kalibao.crud.Edit.prototype.blockUIOptions = $.extend($.kalibao.core.app.defaultBlockUI, {});

  /**
   * Scroll auto
   * @type {boolean}
   */
  $.kalibao.crud.Edit.prototype.activeScrollAuto = true;

  /**
   * {{jQuery}} Wrapper
   */
  $.kalibao.crud.Edit.prototype.$wrapper;

  /**
   * {{jQuery}} Container
   */
  $.kalibao.crud.Edit.prototype.$container;

  /**
   * {{jQuery}} Dynamic container
   */
  $.kalibao.crud.Edit.prototype.$dynamic;

  /**
   * {{jQuery}} Main container
   */
  $.kalibao.crud.Edit.prototype.$main;

  /**
   * Active validators
   * @type {{}}
   */
  $.kalibao.crud.Edit.prototype.activeValidators = {};

  /**
   * Validators
   * @type {Array}
   */
  $.kalibao.crud.Edit.prototype.validators = [];

  /**
   * Init object
   */
  $.kalibao.crud.Edit.prototype.init = function () {
    var self = this;
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.initComponents();
    this.initEvents();
    $.kalibao.core.app.hasUnsavedChanges = function() {
      var changes = false;
      $('form.check-save').each(function(){
        if (self.checkFormState(this, true)) changes = true;
        else self.resetFormState(this);
      });
      return changes
    };
  };

  /**
   * Init components
   */
  $.kalibao.crud.Edit.prototype.initComponents = function () {
    this.initValidators(this.validators, this.activeValidators);
    this.initAdvancedDropDownList(this.$main);
    this.initDatePicker(this.$main);
    this.initWysiwig(this.$main);
    this.initUploader(this.$main);
  };

  /**
   * Init events
   */
  $.kalibao.crud.Edit.prototype.initEvents = function () {
    this.initFormReset();
    this.initFormChange();
    this.initActionsEvents();
  };

  /**
   * Init actions events
   */
  $.kalibao.crud.Edit.prototype.initActionsEvents = function () {
    var self = this;

    $(window).off('popstate');
    $(window).on("popstate", function(e) {
      console.log(e);
      var action = document.URL;
      var params = '';
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
    });

    this.$main.find('.btn-submit').on('click', function() {
      self.submit();
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
  $.kalibao.crud.Edit.prototype.submit = function () {
    var self = this;

    if (window.FormData && ! this.validate(this.activeValidators, this.$main)) {
      var $form = self.$main.find('form');
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
  $.kalibao.crud.Edit.prototype.getDynamicBackLink = function () {
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
  $.kalibao.crud.Edit.prototype.saveDynamicBackLink = function () {
    this.$dynamic.attr('data-back-action', this.$wrapper.attr('data-action') || window.location.href || '');
    this.$dynamic.attr('data-back-params', this.$wrapper.attr('data-params') || '');
    this.$dynamic.attr('data-back-target', this.id);
  };

  /**
   * Save request
   * @param {string} action Request url
   * @param {string} params Request parameters
   */
  $.kalibao.crud.Edit.prototype.saveRequest = function (action, params)
  {
    $.kalibao.core.app.changeUrl(action, params);
    this.$wrapper.attr('data-action', action);
    this.$wrapper.attr('data-params', params);
  };

  /**
   * Init advanced drop dow list components
   * @param {jQuery} $container
   */
  $.kalibao.crud.Edit.prototype.initAdvancedDropDownList = function ($container) {
    $container.find('.input-ajax-select').each(function () {
      $.kalibao.crud.tools.initAdvancedDropDownList($(this));
    });
  };

  $.kalibao.crud.Edit.prototype.files = {};

  /**
   * Init uploader components
   * @param {jQuery} $container
   */
  $.kalibao.crud.Edit.prototype.initUploader = function ($container) {
    var self = this;
    if (window.FormData) {
      $container.find('.input-advanced-uploader').each(function () {
        new $.kalibao.core.Uploader({
          $input: $(this),
          messages: self.messages
        });
      });
    }
  };

  /**
   * Init date picker components
   * @param {jQuery} $container
   */
  $.kalibao.crud.Edit.prototype.initDatePicker = function ($container) {
    $container.find('.date-picker').each(function () {
      $.kalibao.core.app.initDatePicker($(this));
    });
  };

  /**
   * Init wysiwyg components
   * @param {{jQuery}} $container
   */
  $.kalibao.crud.Edit.prototype.initWysiwig = function ($container)
  {
    $container.find('.wysiwyg-textarea').each(function () {
      $.kalibao.core.app.initWysiwyg($(this));
    });
  };

  /**
   * Init validators
   * @param {{}} source
   * @param {{}} destination
   */
  $.kalibao.crud.Edit.prototype.initValidators = function (source, destination) {
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
  $.kalibao.crud.Edit.prototype.validate = function(validators, $container) {
    var hasError = false;

    // clean
    $container.find('.form-group.has-error').removeClass('has-error');
    $container.find('.help-inline').html('');

    for (var attributeName in validators) {
      var id = validators[attributeName].id;
      for (var i in validators[attributeName].script) {
        var messages = [];
        var attribute = {input:'input[data-validator-id=' + id + '], textarea[data-validator-id=' + id + '], select[data-validator-id=' + id + ']'};
        var $inputs = $container.find(attribute.input);
        $inputs.each(function () {
          var $input = $(this);
          var $formGroup = $input.closest('.form-group');
          var $helpInline = $input.nextAll('.help-inline');

          try {
            validators[attributeName].script[i](attribute, $input.val(), messages);
          } catch(e) {
          }

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

  /**
   * Init the buttons to reset the form into their original state
   */
  $.kalibao.crud.Edit.prototype.initFormReset = function() {
    var self = this;
    this.$container.find('.reset-form').off('click').click(function(e){
      e.preventDefault();
      self.resetFormState(self.$container.find('form'));
      return false;
    });
    this.$container.find('.btn-close').click(function(){
      self.resetFormState(self.$container.find('form'));
    })
  };

  /**
   * Init the events for unsaved data warning before changing page or product tab
   */
  $.kalibao.crud.Edit.prototype.initFormChange = function() {
    var self = this;
    //sync ckeditors with textareas to catch the change event

    this.$container.find('form').each(function(){
      self.saveFormState(this)
    });

    for (var i in CKEDITOR.instances) {
      CKEDITOR.instances[i].on('change', function() {this.updateElement(); $(this.element.$).change()});
    }
    $(':input').change(function(){
      var $e = $(this);
      var $form = $e.closest('form');
      if (self.checkFormState($form)) {
        $form.find('.btn-submit').removeClass('btn-default disabled').addClass('btn-primary');
      }
      else {
        $form.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
      }
    });
  };

  /**
   * save the current state of the form in memory for later checks /!\ this function does not save data in database
   * @param form the container of the form
   */
  $.kalibao.crud.Edit.prototype.saveFormState  = function(form) {
    var $form = $(form);
    $form.find(':input:not(:button)').each(function(i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) $input.data('initialState', $input.is(':checked'));
      else $input.data('initialState', $input.val());
    });
    $('.unsaved').removeClass('unsaved');
    $form.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
  };

  /**
   * reverts all changes made on the form since last save
   * @param form the container of the form
   */
  $.kalibao.crud.Edit.prototype.resetFormState = function(form) {
    var $form = $(form);
    $form.find(':input:not(:button)').each(function(i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) $input.prop('checked', $input.data('initialState'));
      else $input.val($input.data('initialState'));
      $input.removeClass('unsaved');
    });
    // reload select 2 data from hidden input
    $form.find('input.input-ajax-select').each(function(){
      $(this).trigger('change');
    });
    $form.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
  };

  /**
   * checks if the form of the given tab contains unsaved data
   * @param form the container of the form
   * @param notify if set to true, add a class to the unsaved elements
   * @returns {boolean} true : unsaved data, false : no unsaved data
   */
  $.kalibao.crud.Edit.prototype.checkFormState = function(form, notify) {
    // set default value
    notify = typeof notify !== 'undefined' ? notify : false;

    var changed = false;
    var $form = $(form);
    $form.find(':input:not(:button)').each(function(i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) {
        if ($input.is(':checked') != $input.data('initialState')) {
          if (notify) {
            $input.removeClass('unsaved');
            setTimeout(function(){$input.addClass('unsaved');}, 1); // setTimeout to restart animation
          }
          changed = true;
        }
      } else {
        if ($input.val() != $input.data('initialState')) {
          if (notify) {
            $input.removeClass('unsaved');
            setTimeout(function(){$input.addClass('unsaved');}, 1); // setTimeout to restart animation
          }
          changed = true;
        }
      }
    });
    return changed;
  };

})(jQuery);