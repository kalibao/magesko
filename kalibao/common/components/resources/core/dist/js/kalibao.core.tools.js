/**
 * Tools component
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
  $.kalibao.core.tools = $.kalibao.core.tools || {};

  /**
   * Remove empty string serialized
   * @param {string} string to transform
   * @return {string}
   */
  $.kalibao.core.tools.removeEmptyStringSerialized = function (string)
  {
    string = string.replace(/[^&]+=\.?(?:&|$)/g, '');
    var iLastChar = string.length - 1;
    if (string[iLastChar] == '&') {
      string = string.substring(0, iLastChar);
    }

    return string;
  };

  /**
   * Set a maximum length for the textarea
   */
  $.kalibao.core.tools.initMaxlengthTextarea = function ()
  {
    $(document).on('keyup', 'textarea', function (){
      var $this = $(this);
      var limit = parseInt($(this).attr('maxlength'));
      var text = $this.val();

      if (text.length > limit) {
        $this.val(text.substr(0, limit));
      }
    });
  };

  /**
   * Test if is the browser is IE and get the number version
   * @returns {Number} or {boolean}
   */
  $.kalibao.core.tools.isIE = function() {
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
  };

  /**
   * Extended
   */
  $.fn.outerHTML = function ()
  {
    return $(this).clone().wrap('<div></div>').parent().html();
  };

  /**
   * Create function
   */
  if (typeof Object.create !== 'function')
  {
    Object.create = function (o) {
      function f() {}
      f.prototype = o;
      return new f();
    };
  }

})(jQuery);