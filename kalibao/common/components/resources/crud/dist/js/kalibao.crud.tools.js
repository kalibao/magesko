/**
 * Tools components of crud
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
  $.kalibao.crud.tools = $.kalibao.crud.tools || {};

  /**
   * Init advanced drop dow list using a modified version of select2.js plugin with custom options
   * @param {{jQuery}} $object jQuery object
   * @param {{}} options select2 options
   */
  $.kalibao.crud.tools.initAdvancedDropDownList = function($object, options)
  {
    var defaultOptions = {
      minimumInputLength: 0,
      allowClear: false,
      initSelection : function (element, callback) {
        callback({id: element.val(), text: element.attr('data-text')});
      },
      nextSearchTerm : function displayCurrentValue(selectedObject, currentSearchTerm) {
        return selectedObject.text;
      },
      dropdownCssClass: 'bigdrop',
      escapeMarkup: function(m) {
        // Do not escape HTML in the select options text
        return m;
      },
      ajax: {
        url: $object.attr('data-action'),
        dataType: 'JSON',
        type: 'GET',
        quietMillis: 250,
        data: function (term, page) {
          return {search: term};
        },
        results: function (data, page) {
          if(data.loginReload) {
            //$.unitkit.app.loginReload(data);
            $object.select2('close');
            $object.select2('open');
          }
          else {
            return {results: data};
          }
        }
      }
    };

    if ($object.attr('data-allow-clear') !== undefined) {
      defaultOptions.allowClear = $object.attr('data-allow-clear');
    }

    if ($object.attr('data-add-action') !== undefined) {
      defaultOptions.addItem = {
        url: $object.attr('data-add-action')
      };
    }

    var dataUpdateAction = $object.attr('data-update-action');
    var dataUpdateArgument = $object.attr('data-update-argument');
    if (dataUpdateAction !== undefined && dataUpdateArgument !== undefined) {
      defaultOptions.updateItem = {
        url: dataUpdateAction,
        argument: dataUpdateArgument
      };
    }

    defaultOptions.item = {};
    if ($object.attr('data-related-field') !== undefined) {
      defaultOptions.item.relatedField = $object.attr('data-related-field');
    } else {
      defaultOptions.item.relatedField = '.select-related-field';
    }

    options = $.extend(defaultOptions, options || {});
    $object.select2(options);
  };


  /**
   * Overload yii compare validator
   * @param attribute
   * @param messages
   * @param options
   */
  yii.validation.compare = function (attribute, value, messages, options) {
    if (options.skipOnEmpty && yii.validation.isEmpty(value)) {
      return;
    }

    var compareValue, valid = true;
    if (options.compareAttribute === undefined) {
      compareValue = options.compareValue;
    } else {
      var $input = $(attribute.input);
      var $container = null;
      var $formInline = $input.closest('.form-inline');

      if ($formInline.length > 0) {
        $container = $formInline;
      } else {
        var $form = $input.closest('form');
        if ($form.length > 0) {
          $container = $form;
        }
      }

      if ($container !== null) {
        var $compareInput = $container.find('input[data-validator-id=inputfield-' + options.compareAttribute + ']');
        if ($compareInput.length > 0) {
          compareValue = $compareInput.val();
        }
      } else {
        compareValue = $('#' + options.compareAttribute).val();
      }
    }

    if (options.type === 'number') {
      value = parseFloat(value);
      compareValue = parseFloat(compareValue);
    }
    switch (options.operator) {
      case '==':
        valid = value == compareValue;
        break;
      case '===':
        valid = value === compareValue;
        break;
      case '!=':
        valid = value != compareValue;
        break;
      case '!==':
        valid = value !== compareValue;
        break;
      case '>':
        valid = parseFloat(value) > parseFloat(compareValue);
        break;
      case '>=':
        valid = parseFloat(value) >= parseFloat(compareValue);
        break;
      case '<':
        valid = parseFloat(value) < parseFloat(compareValue);
        break;
      case '<=':
        valid = parseFloat(value) <= parseFloat(compareValue);
        break;
      default:
        valid = false;
        break;
    }

    if (!valid) {
      yii.validation.addMessage(messages, options.message, value);
    }
  };

})(jQuery);