/**
 * Uploader component
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

  /**
   * Uploader component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.core.Uploader = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * {{jQuery}} Input component
   */
  $.kalibao.core.Uploader.prototype.$input = null;

  /**
   * {{jQuery}} Viewer component
   */
  $.kalibao.core.Uploader.prototype.$viewer = null;

  /**
   * Viewer type (file|image)
   * @type {string}
   */
  $.kalibao.core.Uploader.prototype.type = 'file';

  /**
   * Messages
   * @type {{}}
   */
  $.kalibao.core.Uploader.prototype.messages = $.kalibao.core.app.messages;

  /**
   * Init uploader
   */
  $.kalibao.core.Uploader.prototype.init = function () {
    this.generateViewer();
  };

  /**
   * Clear file Input
   */
  $.kalibao.core.Uploader.prototype.clearFileInput = function () {
    if (this.$input.val() == '') {
      return;
    }
    // Fix for IE ver < 11, that does not clear file inputs
    // Requires a sequence of steps to prevent IE crashing but
    // still allow clearing of the file input.
    if (/MSIE/.test(navigator.userAgent)) {
      var $frm1 = this.$input.closest('form');
      if ($frm1.length) { // check if the input is already wrapped in a form
        this.$input.wrap('<form>');
        var $frm2 = this.$input.closest('form'), // the wrapper form
          $tmpEl = $(document.createElement('div')); // a temporary placeholder element
        $frm2.before($tmpEl).after($frm1).trigger('reset');
        this.$input.unwrap().appendTo($tmpEl).unwrap();
      } else { // no parent form exists - just wrap a form element
        this.$input.wrap('<form>').closest('form').trigger('reset').unwrap();
      }
    } else { // normal reset behavior for other sane browsers
      this.$input.val('');
    }
  };

  /**
   * Generate viewer
   */
  $.kalibao.core.Uploader.prototype.generateViewer = function ()
  {
    var self = this;

    this.$viewer = $('<div class="uploader-viewer hide"></div>');
    this.$input.after(this.$viewer);

    this.type = this.$input.attr('data-type-uploader');
    if (this.type === 'image') {
      this.generateImageViewer();
    } else if(this.type === 'file') {
      this.generateFileViewer();
    }

    this.$input.on('change', function () {
      self.displayViewerContent(this.files[0])
    });
  };


  /**
   * Display viewer content
   * @param {{File}} file File
   */
  $.kalibao.core.Uploader.prototype.displayViewerContent = function (file)
  {
    var self = this;
    if (typeof FileReader !== 'undefined') {
      var reader = new FileReader();
      if (this.type === 'image' && (/image/i).test(file.type)) {
        reader.onload = function (evt) {
          self.$input.attr('value', file.name);
          self.$input.attr('data-img-src', evt.target.result);
          self.generateImageViewer();
        };
      } else {
        reader.onload = function (evt) {
          self.$input.attr('value', file.name);
          self.generateFileViewer();
        };
      }
      reader.readAsDataURL(file);
    }
  };

  /**
   * Generate file viewer
   */
  $.kalibao.core.Uploader.prototype.generateFileViewer = function ()
  {
    var self = this;

    // clear
    this.$viewer.html('');
    this.$input.prevAll('input').val('');

    var url = this.$input.attr('data-file-url');
    if (url !== undefined && url != '') {
      var $title = $('<div class="name"></div>');
      var $a = $('<a>');
      $a.attr('href', url);
      $a.html(this.$input.attr('value'));
      $a.attr('target', '_blank');
      $title.html($a);
      this.$viewer.append($title);

      var $action = $('<div class="action"><a href="#" class="btn btn-default delete">' + this.messages.kalibao.btn_delete + '</a></div>')
      this.$viewer.append($action);
      this.$viewer.removeClass('hide');
      this.$viewer.find('.delete').on('click', function () {
        self.$input.prevAll('input').val('-1');
        self.$input.attr('value', '');
        self.clearFileInput();
        self.$viewer.html('');
        self.$viewer.addClass('hide');
        return false;
      });
    }
  };

  /**
   * Generate image viewer
   */
  $.kalibao.core.Uploader.prototype.generateImageViewer = function ()
  {
    var self = this;

    // clear
    this.$viewer.html('');
    this.$input.prevAll('input').val('');

    var src = this.$input.attr('data-img-src');
    if (src !== undefined && src != '') {
      var $img = $('<img />');

      var width = self.$input.attr('data-img-size-width');
      var height = self.$input.attr('data-img-size-height');

      if(width !== undefined) {
        $img.css('width', width);
      }
      if(height !== undefined) {
        $img.css('height', height);
      }
      $img.attr('src', src);
      this.$viewer.append($img);

      var $title = $('<div class="name"></div>');
      $title.html(this.$input.attr('value'));
      this.$viewer.append($title);

      var $action = $('<div class="action"><a href="#" class="btn btn-default delete">' + this.messages.kalibao.btn_delete + '</a></div>')
      this.$viewer.append($action);
      this.$viewer.removeClass('hide');
      this.$viewer.find('.delete').on('click', function () {
        self.$input.prevAll('input').val('-1');
        self.$input.attr('data-img-src', '');
        self.$input.attr('value', '');
        self.clearFileInput();
        self.$viewer.html('');
        self.$viewer.addClass('hide');
        return false;
      });
    }
  };
})(jQuery);