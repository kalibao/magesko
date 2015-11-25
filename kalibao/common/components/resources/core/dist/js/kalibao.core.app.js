/**
 * Core application component
 *
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao = $.kalibao || {};
  $.kalibao.core = $.kalibao.core || {};
  $.kalibao.core.app = $.kalibao.core.app || {};

  /**
   * Language
   * @type {string}
   */
  $.kalibao.core.app.language = '';

  /**
   * Date picker language
   * @type {{}}
   */
  $.kalibao.core.app.datePickerLanguage = {};

  /**
   * Application messages
   * @type {{}}
   */
  $.kalibao.core.app.messages = {};

  /**
   * Ajax action
   *
   * @param {string} url Url request
   * @param {function} success Success function
   * @param {string} type Request method (GET or POST). The default value is GET
   * @param {string|{FormData}} data Data to send
   * @param {string} dataType Data type (HTML, JSON ...). The default value is HTML
   * @param {bool} async Request is asynchronous. To be synchronous you will set value to false. The default value is true
   */
  $.kalibao.core.app.ajaxQuery = function (url, success, type, data, dataType, async) {
    if (!$.kalibao.core.app.hasUnsavedChanges()) {
      // default arguments
      dataType = dataType || 'HTML';
      type = type || 'GET';
      async = (async !== undefined) ? async : true;
      var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
      var processData = true;

      if (type.toUpperCase() === 'POST') {
        if (data instanceof FormData) {
          contentType = false;
          processData = false;
          data.append(yii.getCsrfParam(), yii.getCsrfToken());
        } else {
          data = data || '';
          data = ((data !== '') ? data + '&' : '') + yii.getCsrfParam() + '=' + encodeURI(yii.getCsrfToken());
        }
      }
      $.ajax({
        url: url,
        data: data,
        dataType: dataType,
        type: type,
        contentType: contentType,
        processData: processData,
        success: function (json) {
          if (json.scripts) {
            for (var i in json.scripts) {
              eval(json.scripts[i]);
            }
          }
          success(json);
        },
        error: function (xhr, status) {
          if (xhr.status == 401) {
            window.location.href = url;
          }
        },
        async: async
      });
    } else {
      $('.content-wrapper > .content-dynamic').unblock();
      $.toaster({ priority : 'warning', title : 'Attention', message : 'Il y a des changements non enregistrés'})
    }
  };

  /**
   * This function is used to check before changing page if there are unsaved changes
   * You need to implement the function following your needs
   * @returns {boolean}
   */
  $.kalibao.core.app.hasUnsavedChanges = function() {
    return false;
  };

  /**
   * Default blockUI configuration
   */
  $.kalibao.core.app.defaultBlockUI = $.extend($.blockUI.defaults, {
    message: '&nbsp;'
  });

  /**
   * Change current Url
   * @param {string} action Request url
   * @param {string} params Request parameters
   */
  $.kalibao.core.app.changeUrl = function (action, params) {
    var self = this;
    if(window.history.pushState && action != window.location && action !== false) {
      var href = action;
      if (href !== undefined) {
        var hasArgs = href.split('?').length > 1;
        if (params !== '' && params !== undefined) {
          if (hasArgs) {
            href += '&' + params;
          } else {
            href += '?' + params;
          }
        }
        window.history.pushState({path: href}, '', href);
      }
    }
  };

  /**
   * Scroll to top
   * @param {integer} scrollTop Top of page
   * @param {integer} time Animate duration
   */
  $.kalibao.core.app.scrollTop = function(scrollTop, duration)
  {
    duration = (duration) ? duration : 200;
    scrollTop = (scrollTop) ? scrollTop : 0;
    $('html,body').animate({scrollTop: scrollTop}, duration);
  };


  /**
   * Init wysiwyg component from an textarea input
   * @param {{jQuery}} $textarea Textarea input
   */
  $.kalibao.core.app.initWysiwyg = function ($textarea) {
    var url = $textarea.attr('data-ckeditor-filebrowser-browse-url');
    var language = $textarea.attr('data-ckeditor-language');

    var options = {};
    if (url !== undefined) {
      options.filebrowserBrowseUrl = url;
    }
    if (language !== undefined) {
      options.language = language;
    }

    $textarea.ckeditor(options);
  };

  /**
   * Init date picker
   * @param {{jQuery}} $input Input file
   */
  $.kalibao.core.app.initDatePicker = function ($input)
  {
    $input.datepicker($.extend(
      $.kalibao.core.app.datePickerLanguage,
      {dateFormat: 'yy-mm-dd'}
    ));
  };

  /**
   * Init upload viewer from an file input
   * @param {{jQuery}} $input File input
   */
  $.kalibao.core.app.initUploadViewer = function ($input)
  {
    var $this = $(this);

    var clearFileInput = function ($input) {
      if ($input.val() == '') {
        return;
      }
      // Fix for IE ver < 11, that does not clear file inputs
      // Requires a sequence of steps to prevent IE crashing but
      // still allow clearing of the file input.
      if (/MSIE/.test(navigator.userAgent)) {
        var $frm1 = $input.closest('form');
        if ($frm1.length) { // check if the input is already wrapped in a form
          $input.wrap('<form>');
          var $frm2 = $input.closest('form'), // the wrapper form
            $tmpEl = $(document.createElement('div')); // a temporary placeholder element
          $frm2.before($tmpEl).after($frm1).trigger('reset');
          $input.unwrap().appendTo($tmpEl).unwrap();
        } else { // no parent form exists - just wrap a form element
          $input.wrap('<form>').closest('form').trigger('reset').unwrap();
        }
      } else { // normal reset behavior for other sane browsers
        $input.val('');
      }
    };

    // create viewer
    var $viewer = $('<div class="uploader-viewer hide"></div>');
    $input.after($viewer);

    var dataImgUrl = $input.attr('data-img-url');
    if (dataImgUrl !== undefined && dataImgUrl != '') {
      var $img = $('<img />');
      var width = $input.attr('data-img-size-width');
      var height = $input.attr('data-img-size-height');
      if(width !== undefined) {
        $img.css('width', width);
      }
      if(height !== undefined) {
        $img.css('height', height);
      }
      $img.attr('src', dataImgUrl);
      $viewer.append($img);

      var $title = $('<div class="name"></div>');
      $title.html($input.attr('value'));
      $viewer.append($title);

      var $action = $('<div class="action"><a href="#" class="btn btn-default remove">Remove</a></div>')
      $viewer.append($action);
      $viewer.removeClass('hide');
      $viewer.find('.remove').on('click', function () {
        $input.prevAll('input').val('-1');
        $input.attr('data-img-url', '');
        $input.attr('value', '');
        $viewer.html('');
        $viewer.addClass('hide');
        return false;
      });
    }

    var displayViewer = function (file) {
      $viewer.html('');
      if (typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
        var reader = new FileReader();
        var $img = $('<img />');
        $viewer.removeClass('hide');
        $viewer.append($img);

        reader.onload = (function ($theImg) {
          return function (evt) {
            $theImg.attr('src', evt.target.result);
            var width = $input.attr('data-img-size-width');
            var height = $input.attr('data-img-size-height');
            if(width !== undefined) {
              $theImg.css('width', width);
            }
            if(height !== undefined) {
              $theImg.css('height', height);
              $input.attr('data-img-url', '');
              $input.attr('value', '');
            }
          };
        }($img));

        reader.readAsDataURL(file);

        $input.prevAll('input').val('');

        var $title = $('<div class="name"></div>');
        $title.html(file.name);
        $viewer.append($title);

        var $action = $('<div class="action"><a href="#" class="btn btn-default delete">Remove</a></div>')
        $viewer.append($action);
        $viewer.removeClass('hide');
        $viewer.find('.remove').on('click', function () {
          $input.prevAll('input').val('-1');
          clearFileInput($input);
          $viewer.html('');
          $viewer.addClass('hide');
          return false;
        });
      }
    };

    $input.on('change', function () {
      displayViewer(this.files[0])
    });
  };
})(jQuery);