/**
 * Modal component
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

  /*
   * Bootstrap hack
   */
  $.fn.modal.Constructor.prototype.enforceFocus = function () {};

  /**
   * Modal component
   * @param {{}} args Argument
   * @constructor
   */
  $.kalibao.core.Modal = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.init();
  };

  /**
   * Init modal
   */
  $.kalibao.core.Modal.prototype.init = function () {
    var self = this;
    this.$component = this.create(this.options);
    this.$component.addClass(this.id);
    this.$component.on('show.bs.modal', function (e) {
      if ($.kalibao.core.Modal.currentModal !== null && self.prevModal === null) {
        self.prevModal = $.kalibao.core.Modal.currentModal;
        $.kalibao.core.Modal.currentModal = self;
        self.prevModal.close();
      } else {
        $.kalibao.core.Modal.currentModal = self;
      }
    });
    this.$component.on('hidden.bs.modal', function (e) {
      if ($.kalibao.core.Modal.currentModal === self) {
        self.remove();
        $.kalibao.core.Modal.currentModal = null;
        if (self.prevModal !== null) {
          self.prevModal.open();
          self.prevModal = null;
        }
      }
    });
  };

  /**
   * Current modal (shared between instances)
   * @type {$.kalibao.core.Modal}
   */
  $.kalibao.core.Modal.currentModal = null;

  /*
   * Interface id
   */
  $.kalibao.core.Modal.prototype.id = null;

  /*
   * Modal options
   */
  $.kalibao.core.Modal.prototype.options = '';

  /**
   * Modal component
   * @type {null}
   */
  $.kalibao.core.Modal.prototype.$component = null;

  /**
   * Modal component
   * @type {null}
   */
  $.kalibao.core.Modal.prototype.$component = null;

  /**
   * Previous Modal
   * @type {$.kalibao.core.Modal}
   */
  $.kalibao.core.Modal.prototype.prevModal = null;

  /**
   * Create Modal
   */
  $.kalibao.core.Modal.prototype.create = function (options) {
    options = (options !== undefined) ? options : '';
    $('#kalibao').append(
      '<div class="modal" role="dialog" tabindex="-1" ' + options + '>' +
        '<div class="modal-dialog">' +
          '<div class="modal-content">' +
            '<div class="modal-header" style="display:none;">' +
              '<h5></h5>' +
            '</div>' +
            '<div class="modal-body" style="display:none;"></div>' +
            '<div class="modal-footer" style="display:none;">' +
              '<a href="#" class="btn btn-primary" style="display:none;"></a>' +
              '<a href="#" class="btn btn-secondary btn-default" style="display:none;"></a>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>'
    );
    return $('#kalibao').children('.modal:last');
  };

  /**
   * Clean values
   */
  $.kalibao.core.Modal.prototype.clean = function () {
    this.setBtnSecondary('');
    this.setBtnPrimary('');
    this.setBody('');
    this.setHeader('');
  };

  /**
   * Close modal
   * @param {boolean} openPrevModal Open previous modal and open previous modal
   */
  $.kalibao.core.Modal.prototype.close = function () {
    this.$component.modal('hide');
  };

  /**
   * Open modal and close previous modal
   */
  $.kalibao.core.Modal.prototype.open = function () {
    this.$component.modal('show');
  };

  /**
   * Remove modal component
   */
  $.kalibao.core.Modal.prototype.remove = function () {
    this.$component.remove();
  };

  /**
   * Set value of secondary button
   * @param {string} value Button value
   */
  $.kalibao.core.Modal.prototype.setBtnSecondary = function (value) {
    var $secondaryBtn = this.$component.find('.btn-secondary');
    if (value != '') {
      $secondaryBtn.show();
      this.$component.find('modal-footer').show();
    } else {
      $secondaryBtn.hide();
      if (this.$component.find('.btn-primary').is(':hidden')) {
        this.$component.find('.modal-footer').hide();
      }
    }
    $secondaryBtn.html(value);
  };

  /**
   * Set value of primary button
   * @param {string} value Button value
   */
  $.kalibao.core.Modal.prototype.setBtnPrimary = function (value) {
    var $btnPrimary = this.$component.find('.btn-primary');
    if (value != '') {
      $btnPrimary.show();
      this.$component.find('.modal-footer').show();
    } else {
      $btnPrimary.hide();
      if (this.$component.find('.btn-secondary').is(':hidden')) {
        this.$component.find('.modal-footer').hide();
      }
    }
    $btnPrimary.html(value);
  };

  /**
   * Set Body
   * @param {string} value Body value
   */
  $.kalibao.core.Modal.prototype.setBody = function (value) {
    if (value != '') {
      this.$component.find('.modal-body').show();
    }
    this.$component.find('.modal-body').html(value);
  };

  /**
   * Set title
   * @param {string} value Header value
   */
  $.kalibao.core.Modal.prototype.setHeader = function (value) {
    if (value != '') {
      this.$component.find('.modal-header').show();
    } else {
      this.$component.find('.modal-header').hide();
    }
    this.$component.find('.modal-header h5').html(value);
  };

})(jQuery);