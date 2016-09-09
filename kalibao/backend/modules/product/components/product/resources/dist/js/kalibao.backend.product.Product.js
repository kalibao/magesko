/**
 * Edit component of crud
 *
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 * @version 1.0
 * @author Kévin Walter <walkev13@gmail.com>
 */
(function ($) {
  'use strict';

  $.kalibao.backend = $.kalibao.backend || {};
  $.kalibao.backend.product = $.kalibao.backend.product || {};

  /**
   * View component
   * @param {{}} args List of arguments
   * @constructor
   */
  $.kalibao.backend.product.View = function (args) {
    for (var i in args) {
      if (this[i] !== undefined) {
        this[i] = args[i];
      }
    }
    this.treeData = args['treeData'];
    this.categories = args['categories'];
    this.init();
  };

  /**
   * Extend class
   * @type {$.kalibao.product.Edit}
   */
  $.kalibao.backend.product.View.prototype = Object.create($.kalibao.crud.Edit.prototype);

  /**
   * Init object
   */
  $.kalibao.backend.product.View.prototype.init = function () {
    var self = this;
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.$crossSellingTab = this.$container.find('#cross_selling');
    this.$attributeTab = this.$container.find('#attribute');
    this.$discountTab = this.$container.find('#discount');
    this.$variantListTab = this.$container.find('#variant-list');
    this.$generatorTab = this.$container.find('#variant-generator');
    this.$logisticTab = this.$container.find('#logistic');
    this.$catalogTab = this.$container.find('#catalog');
    this.$tree = this.$container.find('#tree');
    this.$openAll = this.$catalogTab.find('#open-all');
    this.$closeAll = this.$catalogTab.find('#close-all');
    this.$dropzone = this.$main.find('#dropzone');
    this.$sendMedia = this.$main.find('#send-media');
    this.changed = false;

    $.kalibao.core.app.hasUnsavedChanges = function () {
      if (window.location.pathname.search('/product/product') === -1) return false;
      return self.checkFormState($('.tab-pane.active'));
    };

    this.initComponents();
    this.initTree();
    this.initEvents();
  };

  /**
   * Init components
   */
  $.kalibao.backend.product.View.prototype.initComponents = function () {
    this.initValidators(this.validators, this.activeValidators);
    this.initAdvancedDropDownList(this.$main);
    this.initDatePicker(this.$main);
    this.initWysiwig(this.$main);
    this.initUploader(this.$main);
    this.initSelect2(this.$generatorTab);
  };
  /**
   * Init select2 elements
   */
  $.kalibao.backend.product.View.prototype.initSelect2 = function ($container) {
    $container.find(".select2").each(function () {
      $(this).select2({
        formatSelection: function (e) {
          return $(e.element[0]).closest('optgroup').attr('label') + ' : ' + e.text;
        },
        escapeMarkup: function (m) {
          return m;
        },
        placeholder: $(this).attr('data-placeholder')
      });
    })
  };

  /**
   * Init events
   */
  $.kalibao.backend.product.View.prototype.initEvents = function () {
    this.initDiscountEvents();
    this.initActionsEvents();
    this.initFormReset();
    this.initFormChange();
    this.initCrossSellingEvents();
    this.calcPrices();
    this.initTabHash();
    this.initCopyEvents();
    $('[data-toggle="tooltip"]').tooltip();
    this.$variantListTab.find('input[type=radio]').change(function () {
      $('input[type=radio]:checked').not(this).prop('checked', false);
    });
    this.initTreeEvents();
    this.initGeneratorEvents();
  };

  /**
   * Init tree
   */
  $.kalibao.backend.product.View.prototype.initTree = function () {
    var self = this;
    this.$tree.jstree({
      'core': {
        'data': this.treeData,
        'check_callback': true
      },
      'plugins': ['checkbox'],
      'checkbox': {
        'cascade': 'undetermined',
        'three_state': false,
        'keep_selected_style': false
      }
    });
    this.$tree.on('ready.jstree', function () {
      for (var i = 0; i < self.categories.length; i++) {
        self.$tree.jstree().check_node('branch-' + self.categories[i].branch_id);
      }
      self.initialData = self.$tree.jstree().get_checked();
    });
  };

  /**
   * Init tree events
   */
  $.kalibao.backend.product.View.prototype.initTreeEvents = function () {
    var self = this;
    var $jstree = this.$tree.jstree();
    this.$catalogTab.find('.btn-submit').off('click').on('click', function (e) {
      e.preventDefault();
      var newData = $jstree.get_checked();
      var ad = $(newData).not(self.initialData).get(); // present in new data and not in initial
      var rm = $(self.initialData).not(newData).get(); // present in initial data and not in new
      var productId = self.urlParam('id');
      var Product = {
        link_brand_product: self.$catalogTab.find('[name="Product[link_brand_product]"]').val(),
        link_product_test: self.$catalogTab.find('[name="Product[link_product_test]"]').val()
      };
      $.post('/product/product/update-catalog', {
        ad: ad,
        rm: rm,
        productId: productId,
        Product: Product
      }, function (json) {
        if (self.afterAjaxPost(json)) {
          self.initialData = newData;
          self.saveFormState($('.tab-pane.active'));
        } else {
          self.showErrors(json);
        }
      });
    });

    this.$catalogTab.find('.reset-form').on('click', function () {
      $jstree.uncheck_all();
      $jstree.check_node(self.initialData);
      self.$tree.removeClass('unsaved');
    });

    this.$openAll.on('click', function () {
      $jstree.open_all();
    });

    this.$closeAll.on('click', function () {
      $jstree.close_all();
    })
  };

  /**
   * Init cross selling events
   */
  $.kalibao.backend.product.View.prototype.initCrossSellingEvents = function () {
    var self = this;
    var $variationList = $("#cross_selling_variation");
    $variationList.change(function () {
      $(".cross-selling-table").hide();
      $("#cross_selling_" + $(this).val()).show();
    }).change();

    this.$crossSellingTab.find(".discount-rate").keyup(function () {
      self.updateDiscount("rate", $("#cross_selling"));
    }).keyup();
    this.$crossSellingTab.find(".discount-price").keyup(function () {
      self.updateDiscount("price", $("#cross_selling"));
    });
    this.$crossSellingTab.find(".discount-value").keyup(function () {
      self.updateDiscount("value", $("#cross_selling"));
    });
    this.$crossSellingTab.find("#add-new-cross_sale").click(function (e) {
      e.preventDefault();
      self.addCrossSellingLine($variationList.val());
    });
  };

  /**
   * Init discount events
   */
  $.kalibao.backend.product.View.prototype.initDiscountEvents = function () {
    var self = this;

    var $startDates = this.$discountTab.find("input[name*=start_date]");
    var $endDates = this.$discountTab.find("input[name*=end_date]");

    $("#margin-data").change(function () {
      $(".margin-data").toggle(this.checked);
    });
    $("#base_price").keyup(function () {
      var $e = $("#priceTTC");
      var vat = parseFloat($e.attr("data-vat"));
      $e.val(Math.round($(this).val() * (1 + vat) * 10000) / 10000);
    }).keyup();
    $("#priceTTC").keyup(function () {
      var $e = $("#base_price");
      var vat = parseFloat($(this).attr("data-vat"));
      $e.val(Math.round($(this).val() / (1 + vat) * 10000) / 10000);
    });

    this.$discountTab.find(".discount-rate").keyup(function () {
      self.updateDiscount("rate", $("#discount"));
    }).keyup();
    this.$discountTab.find(".discount-price").keyup(function () {
      self.updateDiscount("price", $("#discount"));
    });
    this.$discountTab.find(".discount-value").keyup(function () {
      self.updateDiscount("value", $("#discount"));
    });
    this.$discountTab.find(".btn-submit").click(function (e) {
      var errors = false;
      for (var i = 0; i < $startDates.length; i++) {
        var start = $startDates.eq(i);
        var end = $endDates.eq(i);

        var startDate = start.val().split('-');
        var endDate = end.val().split('-');
        startDate = new Date(startDate[2], startDate[1], startDate[0]);
        endDate = new Date(endDate[2], endDate[1], endDate[0]);

        if (startDate > endDate) {
          end.addClass('error').tooltip({
            title: end.data('error-text'),
            template: '<div class="tooltip tooltip-danger"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
          })
          errors = true;
        } else {
          end.removeClass('error').tooltip('destroy')
        }
      }
      if (errors) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        return false;
      }
      return true;
    })
  };

  $.kalibao.backend.product.View.prototype.initGeneratorEvents = function () {
    var self = this;
    var showStep2 = function () {
      $('#generator_step1').collapse('hide').parent().children().first().attr('disabled', '');
      $('#generator_step2').collapse('show').parent().children().first().removeAttr('disabled')
    };
    var showStep1 = function () {
      $('#generator_step1').collapse('show').parent().children().first().removeAttr('disabled');
      $('#generator_step2').collapse('hide').parent().children().first().attr('disabled', '');
    };

    $('#generate-combinations').click(function () {
      var $select = $('#generator-attributes');
      if ($select.val()) {
        $.post('generate-combinations', {data: $select.val()}, function (result, resp, jqxhr) {
          console.log(jqxhr);
          for (var key in result) { // loop on combinations
            var newElement = '<label class="variant"><input type="checkbox" name="variant[]" id="variant-' + key + '" value="' + key + '">';

            $.each(result[key], function () {
              newElement += '<span class="badge">' + this + '</span>'
            });
            newElement += '</label><br>';
            $(newElement).prependTo($('#generator_step2').children().first());
          }
          showStep2();
        })
      }
    });

    $('#generate-variants').click(function () {
      var data = [];
      $(this).parent().find(':checked').each(function () {
        data.push($(this).val());
      });
      $.post('add-variant', {
        data: data,
        product: self.urlParam('id')
      }, function () {
        window.location.hash = '#variant-list';
        window.location.reload();
      });
    });

    $('.delete-variant').click(function () {
      var id = $(this).data('id');
      var line = $(this).closest('tr');

      var modal = new $.kalibao.core.Modal({id: 'modal-delete-variant'});
      modal.setHeader($.kalibao.core.app.messages.variantConfirmDelete);
      modal.setBtnPrimary($.kalibao.core.app.messages.btnDelete);
      modal.setBtnSecondary($.kalibao.core.app.messages.btnClose);

      // buttons actions
      modal.$component.find('.btn-secondary, .close').on('click', function () {
        modal.close();
        return false;
      });
      modal.$component.find('.btn-primary').on('click', function () {
        $.post('delete-variant?id=' + id, function (data) {
          modal.close();
          if (self.afterAjaxPost(data)) line.slideUp();
        });
      });
      modal.open();
      modal.$component.find('.btn-primary').focus();
    });
  };

  /**
   * Init actions events
   */
  $.kalibao.backend.product.View.prototype.initActionsEvents = function () {
    var self = this;
    var $tbody = this.$attributeTab.find('tbody');

    var $btnRefresh = $('#refresh-variants');
    var $btnSave = $('#save-attributes');
    $btnRefresh.click(function () {
      location.reload()
    }).hide();
    $btnSave.hide();

    this.$main.find('.btn-submit').on('click', function () {
      self.submit($(this));
      return false;
    });

    this.$main.find('.btn-add-again').on('click', function () {
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

    this.$main.find('.btn-close').on('click', function () {
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

    this.$main.find('.sortable').sortable({
      cursor: "move",
      placeholder: "sortable-placeholder",
      axis: "y",
      scroll: true,
      stop: self.reorderVariants,
      handle: '.sort-handle'
    });

    this.$variantListTab.find('.description-update').click(function () {
      var $textarea = $(this).siblings('textarea').eq(0);
      var data = $textarea.ckeditorGet().getData();
      self.$variantListTab.find($textarea.data('origin')).html(data);
    });

    this.$logisticTab.find('.select-strategy').change(function () {
      $(this).find('option').each(function () {
        $($(this).data('id')).hide();
      });
      $($(this).find(':selected').data('id')).show();
    }).change();

    this.$logisticTab.find('.select-alternative-strategy').change(function () {
      $(this).find('option').each(function () {
        $($(this).data('id')).hide();
      });
      $($(this).find(':selected').data('id')).show();
    }).change();

    this.$logisticTab.find('.save-logistic').click(function (e) {
      e.preventDefault();
      var $modal = $(this).closest('.modal');
      var logisticId = $modal.data('id');

      $.post(
        '/product/product/update-logistic-strategy?id=' + logisticId + '&strategy=' + $modal.find('.select-strategy').eq(0).val() + '&product=' + self.urlParam('id'),
        $modal.find('textarea, input, .select-alternative-strategy').serialize(),
        function (data) {
          $modal.modal('hide');
          self.afterAjaxPost(data)
        }
      );
    });

    this.$main.find('.select-media').change(function () {
      $(this).find('option').each(function () {
        $($(this).data('id')).hide();
      });
      $($(this).find(':selected').data('id')).show();
    }).change();

    this.$main.find('#send-media-url').off('click').click(function (e) {
      e.preventDefault();

      if (window.FormData && !self.validate(self.activeValidators, self.$main)) {
        var $form = $(this).closest('form');
        var action = $form.attr('action');
        var params = new FormData();

        $form.find('input, select, textarea').each(function () {
          var $input = $(this);
          if ($input.attr('name') !== undefined) {
            var inputType = $input.attr('type');
            if (inputType === 'file') {
              if ($input.get(0).files.length > 0) {
                $.each($input.get(0).files, function (i, e) {
                  params.append($input.attr('name'), e);
                });
              }
            } else if (inputType === 'checkbox') {
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
            self.afterAjaxPost(json)
          },
          'POST',
          params,
          'JSON',
          true
        );
      }
      return false
    });

    this.$main.find('.delete-product-media').click(function () {
      var that = this;
      $.post('/product/product/remove-media?id=' + $(this).data('id') + '&product=' + self.urlParam('id'), function () {
        $.toaster({
          priority: 'success',
          title: $.kalibao.core.app.messages.toastSavedTitle,
          message: $.kalibao.core.app.messages.toastFileDeleted
        });
        that.closest('.media').remove();
      });
    });

    this.$dropzone.uploadFile({
      url: '/media/media/create?product=' + self.urlParam('id'),
      fileName: 'Media[file]',
      extraHTML: function () {
        return '<label>Titre :</label><input type="text" class="form-control input-sm" name="MediaI18n[title]"/>';
      },
      autoSubmit: false,
      formData: {'Media[media_type_id]': 1},
      onSuccess: function (file, data, xhr, pd) {
        $.toaster({
          priority: 'success',
          title: $.kalibao.core.app.messages.toastSavedTitle,
          message: $.kalibao.core.app.messages.toastFileUploaded.replace('%file%', file[0])
        })
      },
      afterUploadAll: function (obj) {
        $.toaster({
          priority: 'success',
          title: $.kalibao.core.app.messages.toastSavedTitle,
          message: $.kalibao.core.app.messages.toastUploadComplete.replace('%count%', obj.getFileCount())
        });
        window.location.reload();
      },
      uploadStr: $.kalibao.core.app.messages.uploadSelectFile,
      dragDropStr: '<span> &nbsp; ' + $.kalibao.core.app.messages.uploadDropFile + '</span>',
      acceptFiles: "image/*",
      showPreview: true,
      previewHeight: "auto",
      previewWidth: "auto"
    });

    this.$sendMedia.off('click').click(function () {
      self.$dropzone.startUpload();
    })
  };

  /**
   * Init hash navigation for tabs
   */
  $.kalibao.backend.product.View.prototype.initTabHash = function () {
    var hash = window.location.hash;
    // if (hash == "#" || hash == "") return;
    hash && $('a[href="' + hash + '"]').tab('show');
    this.saveFormState($('.tab-pane.active'));
  };

  /**
   * Submit
   */
  $.kalibao.backend.product.View.prototype.submit = function ($button) {
    var self = this;

    if (window.FormData && !this.validate(this.activeValidators, this.$main)) {
      var $form = $button.closest('form');
      var action = $form.attr('action');
      var params = new FormData();

      if ($form.find('input, select, textarea').hasClass('error')) {
        $.toaster({
          priority: 'danger',
          title: $.kalibao.core.app.messages.toastValidationTitle,
          message: $.kalibao.core.app.messages.toastValidationText
        });
        return false;
      }

      $form.find('input, select, textarea').each(function () {
        var $input = $(this);
        if ($input.attr('name') !== undefined) {
          var inputType = $input.attr('type');
          if (inputType === 'file') {
            if ($input.get(0).files.length > 0) {
              params.append($input.attr('name'), $input.get(0).files[0]);
            }
          } else if (inputType === 'checkbox') {
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
          if (self.afterAjaxPost(json)) {
            var $content = $(json.html);
            self.$wrapper.html($content);
            if (self.activeScrollAuto) {
              $.kalibao.core.app.scrollTop();
            }
            self.saveFormState($('.tab-pane.active'));
          } else {
            self.showErrors(json);
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
   * update the discount prices, rates and values
   * @param change input value changed (one of price, value or rate)
   * @param $container tab where the inputs are
   */
  $.kalibao.backend.product.View.prototype.updateDiscount = function (change, $container) {
    var $lines = $container.find("tr");
    for (var i = $lines.length - 1; i >= 1; i--) {
      var $curline = $lines.eq(i);
      var bprice = parseFloat($curline.find("[disabled]").first().val());
      var $price = $curline.find(".discount-price").first();
      var $value = $curline.find(".discount-value").first();
      var $rate = $curline.find(".discount-rate").first();
      var $fprice = $curline.find(".discount-final-price").first();
      switch (change) {
        case "price":
          var value = bprice - parseFloat($price.val());
          var rate = (value / bprice) * 100;
          $fprice.val($price.val());
          $value.val(Math.round(value * 10000) / 10000);
          $rate.val(Math.round(rate * 100000) / 100000);
          break;
        case "value":
          var value = parseFloat($value.val());
          var fprice = bprice - value;
          var rate = (value / bprice) * 100;
          $fprice.val(Math.round(fprice * 10000) / 10000);
          $price.val(Math.round(fprice * 10000) / 10000);
          $rate.val(Math.round(rate * 100000) / 100000);
          break;
        case "rate":
          var rate = parseFloat($rate.val());
          var value = bprice * rate / 100;
          var fprice = bprice - value;
          $fprice.val(Math.round(fprice * 10000) / 10000);
          $price.val(Math.round(fprice * 10000) / 10000);
          $value.val(Math.round(value * 10000) / 10000);
          break;
      }
    }
  };

  /**
   * calculates the sell prices and margins
   */
  $.kalibao.backend.product.View.prototype.calcPrices = function () {
    var self = this;
    var $buyPriceInput = $('#buyPrice');
    var $sellPriceHTInput = $('#priceHT');
    var $sellPriceTTCInput = $('#priceTTC');
    var $sellPriceTable = $('#sell-prices-table');
    var $buyPriceListInputs = $('#buy-prices-table').find('input[name*="price"]');
    var $sellPriceHTListInputs = $sellPriceTable.find('td:nth-child(2) input').slice(1);
    var $sellPriceTTCListInputs = $sellPriceTable.find('td:nth-child(3) input').slice(1);
    var $marginCoeffInputs = $sellPriceTable.find('td:nth-child(4) input');
    var $marginRateInputs = $sellPriceTable.find('td:nth-child(5) input');
    var multiplier = 1 + $sellPriceHTInput.data('vat');

    var updateMargin = function (line) {
      if (line == null) {
        $buyPriceListInputs.each(function () {
          updateMargin($buyPriceListInputs.index($(this))); // updateMargin for each line
        })
      }
      var buy = $buyPriceListInputs.eq(line).val();
      var sell = $sellPriceTTCListInputs.eq(line).val();

      $marginCoeffInputs.eq(line).val((sell / buy).toFixed(2));
      $marginRateInputs.eq(line).val((100 - (buy / sell) * 100).toFixed(2) + ' %');
    };

    // events for all lines
    $buyPriceInput.on('input', function () {
      var price = $(this).val();
      $buyPriceListInputs.each(function () {
        $(this).val(price);
        updateMargin();
      })
    });

    $sellPriceHTInput.on('input', function () {
      var price = $(this).val();
      $sellPriceHTListInputs.each(function () {  // copy to all HT inputs
        $(this).val(parseFloat(price).toFixed(6));
      });
      $sellPriceTTCListInputs.each(function () { // calc all TTC inputs
        $(this).val((price * multiplier).toFixed(6));
      });
      updateMargin();
    });

    $sellPriceTTCInput.on('input', function () {
      var price = $(this).val();
      $sellPriceTTCListInputs.each(function () { // copy to all TTC input
        $(this).val(parseFloat(price).toFixed(6));
      });
      $sellPriceHTListInputs.each(function () {  // calc all HT inputs
        $(this).val((price / multiplier).toFixed(6));
      });
      updateMargin();
    });


    // individual line edit
    $sellPriceHTListInputs.on('input', function () {
      var index = $sellPriceHTListInputs.index($(this));
      $sellPriceTTCListInputs.eq(index).val(($(this).val() * multiplier).toFixed(6));
      updateMargin(index);
    });

    $sellPriceTTCListInputs.on('input', function () {
      var index = $sellPriceTTCListInputs.index($(this));
      $sellPriceHTListInputs.eq(index).val(($(this).val() / multiplier).toFixed(6));
      updateMargin(index);
    });

    $buyPriceListInputs.on('input', function () {
      updateMargin();
    });

    // trigger input event to calc all datas
    $sellPriceHTListInputs.trigger('input');
  };

  /**
   * returns the value of the url parameter (similar to $_GET() in php)
   * @param name string The param name
   * @returns {*} The value of the url param
   */
  $.kalibao.backend.product.View.prototype.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
      return null;
    }
    else {
      return results[1] || 0;
    }
  };

  /**
   * Function to set the order value of variants after sorting them
   * @param $event Object The event triggered
   * @param $elem Object The ordered object
   */
  $.kalibao.backend.product.View.prototype.reorderVariants = function ($event, $elem) {
    var $table = $elem['item'].parent();
    var order = 1;
    $table.find('tr').each(function () {
      $(this).find('.variant-order').eq(0).val(order++).change();
    })
  };

  /**
   * Function to add a cross sale to a variant
   * @param id int id of the current variant where cross sale is added
   */
  $.kalibao.backend.product.View.prototype.addCrossSellingLine = function (id) {
    $.post('/product/product/add-cross-sale', {
      variant1: id,
      variant2: $("#variant-selector").val()
    }, function () {
      location.reload()
    });
  };

  /**
   * Init the buttons to reset the form into their original state
   */
  $.kalibao.backend.product.View.prototype.initFormReset = function () {
    var self = this;
    $('.tab-pane').each(function (i, e) {
      var $e = $(e);
      $e.find('.reset-form').off('click').click(function (e) {
        e.preventDefault();
        self.resetFormState($e.find('form'));
        return false;
      })
    });

    $('.nav-tabs>li a[href], .btn-primary[href^="#"][href!="#"]').off('click').click(function (e) {
      if ($.inArray(window.location.hash, ['#media', '#attribute', '#']) == -1) { // disable changes verification for some tabs
        if (self.checkFormState($('.tab-pane.active'), true)) {
          $.toaster({
            priority: 'warning',
            title: $.kalibao.core.app.messages.toastUnsavedTitle,
            message: $.kalibao.core.app.messages.toastUnsavedText
          });
          return false;
        }
      }
      // show tab
      $(this).tab('show');
      var scrollmem = $('body').scrollTop();
      window.location.hash = this.hash;
      $('html,body').scrollTop(scrollmem);
      // noinspection JSJQueryEfficiency
      self.saveFormState($('.tab-pane.active'));
    });
  };

  /**
   * Init the events for unsaved data warning before changing page or product tab
   */
  $.kalibao.backend.product.View.prototype.initFormChange = function () {
    var self = this;
    //sync ckeditors with textareas to catch the change event
    for (var i in CKEDITOR.instances) {
      CKEDITOR.instances[i].on('change', function () {
        this.updateElement();
        $(this.element.$).change()
      });
    }
    $(':input').on('input change', function () {
      console.log('input change');
      var $e = $(this);
      var $tab = $e.closest('.tab-pane');
      if (self.checkFormState($tab)) {
        $tab.find('.btn-submit').removeClass('btn-default disabled').addClass('btn-primary');
      }
      else {
        $tab.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
      }
    });

    this.$tree.on('changed.jstree', function () {
      var $tab = self.$catalogTab;
      if (self.checkTreeState()) {
        $tab.find('.btn-submit').removeClass('btn-default disabled').addClass('btn-primary');
      }
      else {
        $tab.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
      }
    })
  };

  /**
   * save the current state of the form in memory for later checks /!\ this function does not save data in database
   * @param tab the container of the form
   */
  $.kalibao.backend.product.View.prototype.saveFormState = function (tab) {
    var $tab = $(tab);
    $tab.find(':input:not(:button)').each(function (i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) $input.data('initialState', $input.is(':checked'));
      else $input.data('initialState', $input.val());
    });
    $('.unsaved').removeClass('unsaved');
    $tab.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
  };

  /**
   * reverts all changes made on the form since last save
   * @param tab the container of the form
   */
  $.kalibao.backend.product.View.prototype.resetFormState = function (tab) {
    var $tab = $(tab);
    $tab.find(':input:not(:button)').each(function (i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) $input.prop('checked', $input.data('initialState'));
      else $input.val($input.data('initialState'));
      $input.removeClass('unsaved error').tooltip('destroy');
    });
    // reload select 2 data from hidden input
    $tab.find('input.input-ajax-select').each(function () {
      $(this).trigger('change');
    });
    $tab.find('.btn-submit').removeClass('btn-primary').addClass('btn-default disabled');
    if ($tab.context.id == 'variant-list') this.sortVariantTable($tab);
  };

  /**
   * checks if the form of the given tab contains unsaved data
   * @param tab the container of the form
   * @param notify if set to true, add a class to the unsaved elements
   * @returns {boolean} true : unsaved data, false : no unsaved data
   */
  $.kalibao.backend.product.View.prototype.checkFormState = function (tab, notify) {
    // set default value
    notify = typeof notify !== 'undefined' ? notify : false;

    var changed = false;
    var $tab = $(tab);
    $tab.find(':input:not(:button):not(.nocheck)').each(function (i, elem) {
      var $input = $(elem);
      if ($input.is(':checkbox')) {
        if ($input.is(':checked') != $input.data('initialState')) {
          if (notify) {
            $input.removeClass('unsaved');
            setTimeout(function () {
              $input.addClass('unsaved');
            }, 1); // setTimeout to restart animation
          }
          changed = true;
        }
      } else {
        if ($input.val() != $input.data('initialState')) {
          if (notify) {
            $input.removeClass('unsaved');
            setTimeout(function () {
              $input.addClass('unsaved');
            }, 1); // setTimeout to restart animation
          }
          changed = true;
        }
      }
    });
    if (window.location.hash == '#catalog') changed = this.checkTreeState(notify) || changed;
    return changed;
  };

  /**
   * sort variant table line according to the number in the order column
   * @param table
   */
  $.kalibao.backend.product.View.prototype.sortVariantTable = function (table) {
    var rows = $(table).find('tbody').find('tr').get();
    rows.sort(function (a, b) {
      var A = $(a).find('.variant-order').val();
      var B = $(b).find('.variant-order').val();

      if (A < B) {
        return -1;
      }
      if (A > B) {
        return 1;
      }
      return 0;
    });

    $.each(rows, function (index, row) {
      $(table).find('table').children('tbody').append(row);
    });
  };

  /**
   * Checks if the tree contains unsaved changes
   * @param notify if set to true, add a class to the unsaved tree
   * @returns {boolean} true : unsaved data, false : no unsaved data
   */
  $.kalibao.backend.product.View.prototype.checkTreeState = function (notify) {
    // set default value
    notify = typeof notify !== 'undefined' ? notify : false;
    if (typeof this.initialData === 'undefined') return false;

    var $jstree = this.$tree.jstree();
    var $tree = this.$tree;

    if (!$jstree.get_checked().equals(this.initialData)) {
      if (notify) {
        setTimeout(function () {
          $tree.addClass('unsaved');
        }, 1); // setTimeout to restart animation
        $tree.removeClass('unsaved');
      }
      return true;
    } else {
      return false;
    }
  };

  /**
   * Init tne buttons to copy the first line of the table in the others
   */
  $.kalibao.backend.product.View.prototype.initCopyEvents = function () {
    var self = this;

    this.$main.find('.copy-first-double').click(function () {
      var col = $(this).parent().index();
      var $tbody = $(this).closest('table').find('tbody');
      var $firstLine = $tbody.find('tr').eq(0);
      var $secondLine = $tbody.find('tr').eq(1);
      $tbody.find('tr').each(function () {
        if ($(this).index() != 0 && $(this).index() != 1) {
          if ($(this).index() % 2 == 0) {
            $(this).find('td').eq(col).find('input').val(
              $firstLine.find('td').eq(col).find('input').val()
            )
          } else {
            $(this).find('td').eq(col - 1).find('input').val(
              $secondLine.find('td').eq(col - 1).find('input').val()
            )
          }
        }
      });
      switch (col) {
        case 2:
          self.updateDiscount('price', $(this).closest('.tab-pane'));
          break;

        case 3:
          self.updateDiscount('value', $(this).closest('.tab-pane'));
          break;

        case 4:
          self.updateDiscount('rate', $(this).closest('.tab-pane'));
          break;
      }
    })
  };

  $.kalibao.backend.product.View.prototype.afterAjaxPost = function (data, reload) {
    reload = typeof reload !== 'undefined' ? reload : false;

    if (typeof data != 'object') data = JSON.parse(data);
    if (data.status === undefined) return false;
    if (data.status == "success") {
      $.toaster({ priority: 'success',
        title: $.kalibao.core.app.messages.toastSavedTitle,
        message: $.kalibao.core.app.messages.toastSavedText });
      if (reload) window.location.reload();
      return true;
    } else {
      $.each(data.errors, function () {
        $.toaster({ priority: 'danger',
          title: $.kalibao.core.app.messages.toastValidationTitle,
          message: this })
      });
      return false;
    }
  };

  $.kalibao.backend.product.View.prototype.showErrors = function (data) {
    for (var field in data.errors) {
      $('[name*=' + field + ']').addClass('unsaved');
    }
  };

})(jQuery);
