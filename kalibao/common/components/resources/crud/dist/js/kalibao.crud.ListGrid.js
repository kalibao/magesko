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

  $.kalibao = $.kalibao || {};
  $.kalibao.crud = $.kalibao.crud || {};

  /**
   * ListGrid component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.crud.ListGrid = function (args) {
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
  $.kalibao.crud.ListGrid.prototype.id = null;

  /**
   * Messages
   * @type {{}}
   */
  $.kalibao.crud.ListGrid.prototype.messages = $.kalibao.core.app.messages;

  /**
   * Scroll auto
   * @type {boolean}
   */
  $.kalibao.crud.ListGrid.prototype.activeScrollAuto = true;

  /**
   * BlockUI options
   */
  $.kalibao.crud.ListGrid.prototype.blockUIOptions = $.extend($.kalibao.core.app.defaultBlockUI, {});

  /**
   * {{jQuery}} Wrapper
   */
  $.kalibao.crud.ListGrid.prototype.$wrapper;

  /**
   * {{jQuery}} Container
   */
  $.kalibao.crud.ListGrid.prototype.$container;

  /**
   * {{jQuery}} Dynamic container
   */
  $.kalibao.crud.ListGrid.prototype.$dynamic;

  /**
   * {{jQuery}} Main container
   */
  $.kalibao.crud.ListGrid.prototype.$main;

  /**
   * {{jQuery}} advanced filters component
   */
  $.kalibao.crud.ListGrid.prototype.$advancedFilter;

  /**
   * {{jQuery}} action component
   */
  $.kalibao.crud.ListGrid.prototype.$action;

  /**
   * {{jQuery}} grid component
   */
  $.kalibao.crud.ListGrid.prototype.$grid;

  /**
   * {{jQuery}} grid body component
   */
  $.kalibao.crud.ListGrid.prototype.$gridBody;

  /**
   * {{jQuery}} head filters component
   */
  $.kalibao.crud.ListGrid.prototype.$gridHeadFilter;

  /**
   * {{jQuery}} head titles component
   */
  $.kalibao.crud.ListGrid.prototype.$gridHeadTitle;

  /**
   * {{jQuery}} footer component
   */
  $.kalibao.crud.ListGrid.prototype.$gridFooter;

  /**
   * Active validators
   * @type {{advancedFilters: {}, gridHeadFilters: {}, gridRowEdit: {}}}
   */
  $.kalibao.crud.ListGrid.prototype.activeValidators = {
    advancedFilters: {},
    gridHeadFilters: {},
    gridRowEdit: {}
  };

  /**
   * Advanced filters validators
   * @type {Array}
   */
  $.kalibao.crud.ListGrid.prototype.advancedFiltersValidators = [];

  /**
   * Head filters validators
   * @type {Array}
   */
  $.kalibao.crud.ListGrid.prototype.gridHeadFiltersValidators = [];


  /**
   * Grid row validators
   * @type {Array}
   */
  $.kalibao.crud.ListGrid.prototype.gridRowEditValidators = [];

  /**
   * Init object
   */
  $.kalibao.crud.ListGrid.prototype.init = function () {
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.$action = this.$main.find('.actions');
    this.$advancedFilter = this.$main.find('.advanced-filters');
    this.$grid = this.$main.find('.list-grid');
    this.$gridHeadTitle = this.$grid.find('.head-titles');
    this.$gridHeadFilter = this.$grid.find('.head-filters');
    this.$gridBody = this.$grid.find('tbody');
    this.$gridFooter = this.$grid.find('tfoot');
    this.initComponents();
    this.initEvents();
  };

  /**
   * Init components
   */
  $.kalibao.crud.ListGrid.prototype.initComponents = function () {
    this.initValidators(this.advancedFiltersValidators, this.activeValidators.advancedFilters);
    this.initValidators(this.gridHeadFiltersValidators, this.activeValidators.gridHeadFilters);
    this.initAdvancedDropDownList(this.$advancedFilter);
    this.initAdvancedDropDownList(this.$gridHeadFilter);
    this.initDatePicker(this.$advancedFilter);
    this.initDatePicker(this.$gridHeadFilter);
  };

  /**
   * Init events
   */
  $.kalibao.crud.ListGrid.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initAdvancedFiltersEvents();
    this.initHeadTitlesEvents();
    this.initHeadFiltersEvents();
    this.initPageEvents();
    this.initCheckAllRowsEvents();
    this.initDeleteAllRowsEvent();
    this.initDeleteRowsEvents(this.$gridBody);
    this.initRowActionsEvents(this.$gridBody);
    this.initSelectRowEvents(this.$gridBody);
  };

  /**
   * Get back link
   * The function return an object containing action and target or false
   * @returns {*}
   */
  $.kalibao.crud.ListGrid.prototype.getDynamicBackLink = function () {
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
  $.kalibao.crud.ListGrid.prototype.saveDynamicBackLink = function () {
    this.$dynamic.attr('data-back-action', this.$wrapper.attr('data-action') || window.location.href || '');
    this.$dynamic.attr('data-back-params', this.$wrapper.attr('data-params') || '');
    this.$dynamic.attr('data-back-target', this.id);
  };

  /**
   * Save request
   * @param {string} action Request url
   * @param {string} params Request parameters
   */
  $.kalibao.crud.ListGrid.prototype.saveRequest = function (action, params)
  {
    $.kalibao.core.app.changeUrl(action, params);
    this.$wrapper.attr('data-action', action);
    this.$wrapper.attr('data-params', params);
  };

  /**
   * Init advanced drop down list component
   * @param {{jQuery}} $container
   */
  $.kalibao.crud.ListGrid.prototype.initAdvancedDropDownList = function ($container) {
    $container.find('.input-ajax-select').each(function () {
      $.kalibao.crud.tools.initAdvancedDropDownList($(this));
    });
  };

  /**
   * Init upload viewer components
   * @param {jQuery} $container
   */
  $.kalibao.crud.ListGrid.prototype.initUploadViewer = function ($container) {
    if (window.FormData) {
      $container.find('.input-advanced-uploader').each(function () {
        $.kalibao.core.app.initUploadViewer($(this));
      });
    }
  };

  /**
   * Init date picker components
   * @param {jQuery} $container
   */
  $.kalibao.crud.ListGrid.prototype.initDatePicker = function ($container) {
    $container.find('.date-picker').each(function () {
      $.kalibao.core.app.initDatePicker($(this));
    });
  };

  /**
   * Init wysiwyg components
   * @param {{jQuery}} $container
   */
  $.kalibao.crud.ListGrid.prototype.initWysiwig = function ($container)
  {
    $container.find('.wysiwyg-textarea').each(function () {
      $.kalibao.core.app.initWysiwyg($(this));
    });
  };

  /**
   * Init uploader components
   * @param {jQuery} $container
   */
  $.kalibao.crud.ListGrid.prototype.initUploader = function ($container) {
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
   * Load data grid
   * @param {string} action Request Url
   * @param {string} params Request parameters
   */
  $.kalibao.crud.ListGrid.prototype.loadDataGrid = function(action, params) {
    var self = this;

    this.$wrapper.block(self.blockUIOptions);

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
  };

  /**
   * Submit advanced filters
   */
  $.kalibao.crud.ListGrid.prototype.submitAdvancedFilters = function () {
    var self = this;

    if (! this.validate(this.activeValidators.advancedFilters, this.$advancedFilter)) {
      var action = self.$advancedFilter.find('form').attr('action');
      var params = $.kalibao.core.tools.removeEmptyStringSerialized(self.$advancedFilter.find('input[value!=""], select').serialize());
      this.loadDataGrid(action, params);
    }
  };

  /**
   * Submit head filters
   */
  $.kalibao.crud.ListGrid.prototype.submitHeadFilters = function () {
    var self = this;

    if (! this.validate(this.activeValidators.gridHeadFilters, this.$gridHeadFilter)) {
      var action = self.$gridHeadFilter.find('.btn-search').attr('href');
      var params = $.kalibao.core.tools.removeEmptyStringSerialized(self.$gridHeadFilter.find('input[value!=""], select').serialize());
      this.loadDataGrid(action, params);
    }
  };

  /**
   * Init validators
   * @param {{}} source
   * @param {{}} destination
   */
  $.kalibao.crud.ListGrid.prototype.initValidators = function (source, destination) {
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
  $.kalibao.crud.ListGrid.prototype.validate = function(validators, $container) {
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
   * Init row actions events
   */
  $.kalibao.crud.ListGrid.prototype.initRowEditEvents = function ($container) {
    var self = this;

    $container.find('input').on('keyup', function (e) {
      if (e.keyCode === 13) {
        $container.find('.btn-update-row').click();
      }
      return false;
    });

    $container.find('.btn-close-row').on('click', function () {
      var $this = $(this);
      var executeRequest = function (async) {
        $.kalibao.core.app.ajaxQuery(
          $this.attr('href'),
          function (json) {
            if (json.loginReload) {

            } else {
              var $content = $(json.html);
              $this.closest('tr').replaceWith($content)
              self.initRowActionsEvents($content);
              self.initSelectRowEvents($content);
              self.initDeleteRowsEvents($content);
              self.$wrapper.unblock();
            }
          },
          'GET',
          '',
          'JSON',
          async
        );
      };

      self.$wrapper.block(self.blockUIOptions);
      executeRequest(true);

      return false;
    });

    $container.find('.btn-update-row').on('click', function () {
      var $this = $(this);
      var $tr = $this.closest('tr');

      if (window.FormData && ! self.validate(self.activeValidators.gridRowEdit, $tr)) {
        var action = $this.attr('href');
        var params = new FormData();

        $tr.find('input, select, textarea').each(function () {
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

        var executeRequest = function (async) {
          $.kalibao.core.app.ajaxQuery(
            action,
            function (json) {
              if (json.loginReload) {

              } else {
                var $content = $(json.html);
                $tr.replaceWith($content);
                if (json.saved) {
                  self.initRowActionsEvents($content);
                  self.initSelectRowEvents($content);
                  self.initDeleteRowsEvents($content);
                } else {
                  self.initDatePicker($content);
                  self.initRowEditEvents($content);
                  self.initAdvancedDropDownList($content);
                  self.initWysiwig($content);
                  self.initUploader($content);
                }
                self.$wrapper.unblock();
              }
            },
            'POST',
            params,
            'JSON',
            async
          );
        };

        self.$wrapper.block(self.blockUIOptions);
        executeRequest(true);
      }

      return false;
    });
  };

  /**
   * Edit row
   * @param {{jQuery}} $row
   * @param callback
   */
  $.kalibao.crud.ListGrid.prototype.editRow = function ($row, callback) {
    var self = this;
    var url = $row.find('.btn-edit-row').attr('href');
    var executeRequest = function (async) {
      $.kalibao.core.app.ajaxQuery(
        url,
        function (json) {
          if (json.loginReload) {

          } else {
            var $content = $(json.html);
            $row.replaceWith($content);
            self.initAdvancedDropDownList($content);
            self.initDatePicker($content);
            self.initWysiwig($content);
            self.initUploader($content);
            self.initRowEditEvents($content);
            if (self.gridRowEditValidators.length === 0 && json.validators) {
              self.gridRowEditValidators = json.validators;
              self.initValidators(self.gridRowEditValidators, self.activeValidators.gridRowEdit);
            }
            if(typeof callback !== 'undefined') {
              callback();
            }
            self.$wrapper.unblock();
          }
        },
        'GET',
        '',
        'JSON',
        async
      );
    };

    self.$wrapper.block(self.blockUIOptions);
    executeRequest(true);
  };

  /**
   * Init row actions events
   */
  $.kalibao.crud.ListGrid.prototype.initRowActionsEvents = function ($container) {
    var self = this;

    $container.find('.btn-edit-row').on('click', function () {
      self.editRow($(this).closest('tr'));
      return false;
    });

    $container.find('.btn-update, .btn-translate, .btn-view').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      self.$wrapper.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          self.$main.remove();
          $('title').html(json.title);
          var $content = $(json.html);
          self.$dynamic.html($content);
          self.saveDynamicBackLink();
          $.kalibao.core.app.changeUrl(action, params);
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
  };

  /**
   * Init actions events
   */
  $.kalibao.crud.ListGrid.prototype.initActionsEvents = function () {
    var self = this;

    this.$action.find('.btn-create, .btn-settings').on('click', function() {
      var action = $(this).attr('href');
      var params = '';

      self.$wrapper.block(self.blockUIOptions);

      $.kalibao.core.app.ajaxQuery(
        action,
        function (json) {
          self.$main.remove();
          $('title').html(json.title);
          var $content = $(json.html);
          self.$dynamic.html($content);
          self.saveDynamicBackLink();
          $.kalibao.core.app.changeUrl(action, params);
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

    this.$action.find('.btn-advanced-filters').on('click', function () {
      self.$wrapper.attr('data-open-advanced-filters', '1');
      self.$advancedFilter.show();
      return false;
    });
  };

  /**
   * Init head titles events
   */
  $.kalibao.crud.ListGrid.prototype.initHeadTitlesEvents = function () {
    var self = this;
    this.$gridHeadTitle.find('a').on('click', function () {
      self.loadDataGrid($(this).attr('href'), '');
      return false;
    });
  };

  /**
   * Init page events
   */
  $.kalibao.crud.ListGrid.prototype.initPageEvents = function () {
    var self = this;
    this.$main.find('.pagination a').on('click', function () {
      self.loadDataGrid($(this).attr('href'), '');
      return false;
    });
  };

  /**
   * Init advanced filters events
   */
  $.kalibao.crud.ListGrid.prototype.initAdvancedFiltersEvents = function () {
    var self = this;

    if (this.$wrapper.attr('data-open-advanced-filters') === '1') {
      this.$advancedFilter.show();
    }

    this.$advancedFilter.find('.close').on('click', function () {
      self.$wrapper.removeAttr('data-open-advanced-filters');
      self.$advancedFilter.hide();
      return false;
    });

    this.$advancedFilter.find('.btn-search').on('click', function () {
      self.submitAdvancedFilters();
      return false;
    });

    this.$advancedFilter.find('input').on('keyup', function (e) {
      if (e.keyCode === 13) {
        self.submitAdvancedFilters();
      }
      return false;
    });
  };

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
  };

  /**
   * Init check all rows events
   */
  $.kalibao.crud.ListGrid.prototype.initCheckAllRowsEvents = function () {
    var self = this;

    this.$gridFooter.find('.check-all').on('click', function () {
      var $input = self.$grid.find('input[type=checkbox].check-row');
      $input.closest('tr').addClass('row-selected');
      $input.prop('checked', true);
      return false;
    });

    this.$gridFooter.find('.uncheck-all').on('click', function () {
      var $input = self.$grid.find('input[type=checkbox].check-row');
      $input.closest('tr').removeClass('row-selected');
      $input.prop('checked', false);
      return false;
    });
  };

  /**
   * Init select row events
   */
  $.kalibao.crud.ListGrid.prototype.initSelectRowEvents = function ($container) {
    var self = this;

    $container.find('input[type=checkbox].check-row').on('change', function () {
      var $this = $(this);
      var $tr = $this.closest('tr');
      if ($this.is(':checked')) {
        $tr.addClass('row-selected');
      } else {
        $tr.removeClass('row-selected');
      }
    });

    $container.find('td:not(.td-action)')
      .on('click', function (e){
        var $tr = $(this).closest('tr');
        var $checkRow = $tr.children('td:first').find('.check-row');
        var $target = $(e.target);

        if (! $target.is('input, textarea, select') && $checkRow.length > 0) {
          var isChecked = $checkRow.is(':checked');
          if (isChecked) {
            $tr.removeClass('row-selected');
          } else {
            $tr.addClass('row-selected');
          }
          $checkRow.prop('checked', ! isChecked);
        }
      }).on('dblclick', function (e) {
        var $this = $(this);
        var $target = $(e.target);
        var $tr = $this.closest('tr');
        var $editButton = $tr.children('td:first').find('.btn-edit-row');

        if ($editButton.length > 0) {
          var callback = undefined;
          if ($target.is('td')) {
            var trIndex = $tr.index();
            var tdIndex = $this.index();

            callback = function () {
              var $tr = self.$gridBody.children('tr:eq(' + trIndex + ')');
              var $td = $tr.children('td:eq(' + tdIndex + ')');
              var $input = $td.find(':input:not([type=hidden], [type=checkbox], select, textarea)');
              if ($input.length > 0) {
                var inputVal = $td.find('input').val();
                $input.focus().val('').val(inputVal);
              }
            };
          }

          self.editRow($(this).closest('tr'), callback);
        }
      });
  };

  /**
   * Delete rows
   */
  $.kalibao.crud.ListGrid.prototype.initDeleteRowsEvents = function ($container) {
    var self = this;

    $container.find('.btn-delete-row').on('click', function () {
      var $this = $(this);
      var params = $this.attr('data-name') + '=' + encodeURIComponent($this.attr('data-value'));

      var modal = new $.kalibao.core.Modal({id:'modal-delete-row'});
      modal.setHeader(self.messages.kalibao.modal_remove_one);
      modal.setBtnPrimary(self.messages.kalibao.btn_confirm);
      modal.setBtnSecondary(self.messages.kalibao.btn_cancel);

      // buttons actions
      modal.$component.find('.btn-secondary, .close').on('click', function () {
        modal.close();
        return false;
      });

      modal.$component.find('.btn-primary').on('click', function () {
        $.kalibao.core.app.ajaxQuery(
          $this.attr('href'),
          function (json) {
            var action = self.$wrapper.attr('data-action') || window.location.href || '';
            var params = self.$wrapper.attr('data-params') || '';
            self.loadDataGrid(action, params);
          },
          'POST',
          (params !== '' ? params : ''),
          'JSON',
          true
        );

        modal.close();
        return false;
      });

      modal.open();
      return false;
    });
  };

  /**
   * Delete all rows
   */
  $.kalibao.crud.ListGrid.prototype.initDeleteAllRowsEvent = function ()
  {
    var self = this;

    this.$gridFooter.find('.btn-delete-all').on('click', function () {
      var $checkBoxSelector = self.$gridBody.find('tr input[type=checkbox].check-row:checked');
      if ($checkBoxSelector.length > 0) {
        var $this = $(this);

        var modal = new $.kalibao.core.Modal({id:'modal-delete-all'});
        modal.setHeader(self.messages.kalibao.modal_remove_selected);
        modal.setBtnPrimary(self.messages.kalibao.btn_confirm);
        modal.setBtnSecondary(self.messages.kalibao.btn_cancel);

        modal.$component.find('.btn-secondary, .close').on('click', function (){
          modal.close();
          return false;
        });
        modal.$component.find('.btn-primary').on('click', function (){
          $.kalibao.core.app.ajaxQuery(
            $this.attr('href'),
            function (json) {
              var action = self.$wrapper.attr('data-action') || window.location.href || '';
              var params = self.$wrapper.attr('data-params') || '';
              self.loadDataGrid(action, params);
            },
            'POST',
            $.kalibao.core.tools.removeEmptyStringSerialized($checkBoxSelector.serialize()),
            'JSON',
            true
          );

          modal.close();
          return false;
        });
        modal.open();
      }
      return false;
    });
  };

})(jQuery);