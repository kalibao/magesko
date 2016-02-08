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
    this.$container = $('#' + this.id);
    this.$wrapper = this.$container.closest('.content-dynamic');
    this.$main = this.$container.find('.content-main');
    this.$dynamic = this.$container.find('.content-dynamic');
    this.$crossSellingTab = this.$container.find('#cross_selling');
    this.$attributeTab = this.$container.find('#attribute');
    this.$discountTab = this.$container.find('#discount');
    this.$variantListTab = this.$container.find('#variant-list');
    this.$logisticTab = this.$container.find('#logistic');
    this.$catalogTab = this.$container.find('#catalog');
    this.$tree = this.$container.find('#tree');
    this.$openAll = this.$catalogTab.find('#open-all');
    this.$closeAll = this.$catalogTab.find('#close-all');
    this.$dropzone = this.$main.find('#dropzone');
    this.$sendMedia = this.$main.find('#send-media');


    this.initComponents();
    this.initTree();
    this.initEvents();
  };

  /**
   * Init events
   */
  $.kalibao.backend.product.View.prototype.initEvents = function () {
    this.initActionsEvents();
    this.initCrossSellingEvents();
    this.initDiscountEvents();
    this.initTabHash();
    this.initFormReset();
    this.initCopyEvents();
    $('[data-toggle="tooltip"]').tooltip();
    this.$variantListTab.find('input[type=radio]').change(function() {
      $('input[type=radio]:checked').not(this).prop('checked', false);
    });
    this.initTreeEvents();
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
    this.$tree.on('ready.jstree', function(){
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
    this.$catalogTab.find('.btn-submit').off('click').on('click', function(e) {
      e.preventDefault();
      var newData = $jstree.get_checked();
      var ad = $(newData).not(self.initialData).get();
      var rm = $(self.initialData).not(newData).get();
      var productId = self.urlParam('id');
      $.post('/product/product/update-catalog', {ad: ad, rm: rm, productId: productId}, function(){
        $.toaster({priority: 'success', title: 'Enregistré', message: 'Modifications enregistrées'})
      });
      self.initialData=newData;
    });

    this.$catalogTab.find('.reset-form').on('click', function() {
      $jstree.uncheck_all();
      $jstree.check_node(self.initialData);
    });

    this.$openAll.on('click', function() {
      $jstree.open_all();
    });

    this.$closeAll.on('click', function() {
      $jstree.close_all();
    })
  };

  /**
   * Init cross selling events
   */
  $.kalibao.backend.product.View.prototype.initCrossSellingEvents = function () {
    var self = this;
    var $variationList = $("#cross_selling_variation");
    $variationList.change(function(){
      $(".cross-selling-table").hide();
      $("#cross_selling_" + $(this).val()).show();
    }).change();

    this.$crossSellingTab.find(".discount-rate" ).keyup(function(){
      self.updateDiscount("rate", $("#cross_selling"));
    }).keyup();
    this.$crossSellingTab.find(".discount-price").keyup(function(){
      self.updateDiscount("price", $("#cross_selling"));
    });
    this.$crossSellingTab.find(".discount-value").keyup(function(){
      self.updateDiscount("value", $("#cross_selling"));
    });
    this.$crossSellingTab.find("#add-new-cross_sale").click(function(e){
      e.preventDefault();
      self.addCrossSellingLine($variationList.val());
    });
  };

  /**
   * Init discount events
   */
  $.kalibao.backend.product.View.prototype.initDiscountEvents = function () {
    var self = this;

    $("#margin-data").change(function(){
      $(".margin-data").toggle(this.checked);
    });
    $("#base_price").keyup(function(){
      var $e = $("#priceTTC");
      var vat = parseFloat($e.attr("data-vat"));
      $e.val(Math.round($(this).val() * (1 + vat)*10000)/10000);
    }).keyup();
    $("#priceTTC").keyup(function(){
      var $e = $("#base_price");
      var vat = parseFloat($(this).attr("data-vat"));
      $e.val(Math.round($(this).val() / (1 + vat)*10000)/10000);
    });
    $("#prices").find("input").keyup(self.calcPrices).keyup();

    this.$discountTab.find(".discount-rate" ).keyup(function(){
      self.updateDiscount("rate", $("#discount"));
    }).keyup();
    this.$discountTab.find(".discount-price").keyup(function(){
      self.updateDiscount("price", $("#discount"));
    });
    this.$discountTab.find(".discount-value").keyup(function(){
      self.updateDiscount("value", $("#discount"));
    });
  };
  
  /**
   * Init actions events
   */
  $.kalibao.backend.product.View.prototype.initActionsEvents = function () {
    var self   = this;
    var $tbody = this.$attributeTab.find('tbody');

    var $btnRefresh = $('#refresh-variants');
    var $btnSave = $('#save-attributes');
    $btnRefresh.click(function(){location.reload()}).hide();
    $btnSave.hide();

    this.$main.find('.btn-submit').on('click', function() {
      self.submit($(this));
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

    this.$main.find('.sortable').sortable({
      cursor: "move",
      placeholder: "sortable-placeholder",
      axis: "y",
      scroll: true,
      stop: self.reorderVariants
    });

    this.$attributeTab.find('.attribute-delete').click(function() {
      if (confirm('supprimer un attribut effacera toutes les variations qui l\'utilisent.\nSupprimer ?')) {
        var $btn = $(this);
        $.post("delete-attribute", {
          id: $(this).data('attribute'),
          product: $(this).data('product')
        }).done(function() {
          $btn.parent().fadeOut();
        })
      }
      $btnRefresh.show();
    });

    this.$attributeTab.find('.attribute-type-delete').click(function() {
      if (confirm('supprimer un attribut effacera toutes les variations qui l\'utilisent.\nSupprimer ?')) {
        var $btn = $(this);
        $.post("delete-attribute", {
          ids: $(this).data('attribute-list'),
          product: $(this).data('product')
        }).done(function() {
          $btn.closest('tr').fadeOut();
        })
      }
      $btnRefresh.show();
    });

    this.$attributeTab.find('#add-attribute').click(function() {
      var $input = $('#input-attribute');
      var value = $input.val();
      $input.select2('destroy');
      $.kalibao.crud.tools.initAdvancedDropDownList($input);
      if (!value) return;

      var attributeType = $('#input-attribute-type').val().split('|');
      value = value.split('|');

      if (!$tbody.find("#attr-type-" + attributeType[0]).length) {
        $tbody.prepend($("<tr data-id='"+ attributeType[0] +"' id='attr-type-"+ attributeType[0] +"'><td>"+ attributeType[1] +"</td><td></td></tr>" + attributeType[0]));
      }

      var $td = $("#attr-type-" + attributeType[0]).find('td').eq(1);
      if (!$td.find("#attr-" + value[0]).length)
        $td.append($('<span class="badge" data-id="'+ value[0] +'" id="attr-'+ value[0] +'">'+ value[1] +'</span>'))

      $btnSave.show();
    });

    this.$attributeTab.find('#input-attribute-type').change(function(){
      var $attributes = $("#input-attribute");
      $attributes.select2('destroy');
      $attributes.attr("data-action", $(this).data("attribute-url") + '|' + $(this).val());
      $.kalibao.crud.tools.initAdvancedDropDownList($attributes);
    });

    this.$attributeTab.find('#save-attributes').click(function(){
      var data = {};
      $tbody.find('tr').each(function(){
        if ($(this).find('input').length) return;
        var typeId = $(this).first('td').data('id');
        data[typeId] = [];
        $(this).last('td').find('span').each(function(){
          data[typeId].push($(this).data('id'))
        })
      });
      var product = self.urlParam('id');
      $.post('/product/product/add-attribute', {data: data, product: product}, function(){location.reload()});
    });

    this.$variantListTab.find('.description-update').click(function(){
      var $textarea = $(this).siblings('textarea').eq(0);
      var data = $textarea.ckeditorGet().getData();
      self.$variantListTab.find($textarea.data('origin')).html(data);
    });

    this.$logisticTab.find('.select-strategy').change(function(){
      $(this).find('option').each(function(){
        $($(this).data('id')).hide();
      });
      $($(this).find(':selected').data('id')).show();
    }).change();

    this.$logisticTab.find('.select-alternative-strategy').change(function(){
      $(this).find('option').each(function(){
        $($(this).data('id')).hide();
      });
      $($(this).find(':selected').data('id')).show();
    }).change();

    this.$logisticTab.find('.save-logistic').click(function(e){
      e.preventDefault();
      var $modal = $(this).closest('.modal');
      var logisticId = $modal.data('id');

      $.post(
        '/product/product/update-logistic-strategy?id=' + logisticId + '&strategy=' + $modal.find('.select-strategy').eq(0).val() + '&product=' + self.urlParam('id'),
        $modal.find('textarea, input, .select-alternative-strategy').serialize(),
        function() {$modal.modal('hide')}
      );
    });

    this.$main.find('.select-media').change(function(){
      $(this).find('option').each(function(){
        $($(this).data('id')).hide();
      });
      $($(this).find(':selected').data('id')).show();
    }).change();

    this.$main.find('#send-media-url').off('click').click(function(e){
      e.preventDefault();
      console.log('coucou');

      if (window.FormData && ! self.validate(self.activeValidators, self.$main)) {
        var $form = $(this).closest('form');
        var action = $form.attr('action');
        var params = new FormData();

        $form.find('input, select, textarea').each(function () {
          var $input = $(this);
          if ($input.attr('name') !== undefined) {
            var inputType = $input.attr('type');
            if (inputType === 'file') {
              if ($input.get(0).files.length > 0) {
                $.each($input.get(0).files, function(i, e){
                  params.append($input.attr('name'), e);
                });
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
            console.log('finish');
            window.location.reload();
          },
          'POST',
          params,
          'JSON',
          true
        );
      }
      return false
    });

    this.$main.find('.delete-product-media').click(function(){
      $.post('/product/product/remove-media?id=' + $(this).data('id') + '&product=' + self.urlParam('id'), function(){
        location.reload();
      });
    });

    this.$dropzone.uploadFile({
      url: '/media/media/create?product=' + self.urlParam('id'),
      fileName: 'Media[file]',
      extraHTML: function(){
        return '<label>Titre :</label><input type="text" class="form-control input-sm" name="MediaI18n[title]"/>';
      },
      autoSubmit: false,
      formData: {'Media[media_type_id]': 1},
      onSuccess: function(){
        window.location.reload();
      },
      uploadStr: 'Parcourir',
      dragDropStr: '<span> &nbsp; ou déposez vos Fichiers</span>',
      acceptFiles: "image/*",
      showPreview: true,
      previewHeight: "auto",
      previewWidth: "auto"
    });

    this.$sendMedia.off('click').click(function(){
      self.$dropzone.startUpload();
    })
  };

  /**
   * Init hash navigation for tabs
   */
  $.kalibao.backend.product.View.prototype.initTabHash = function () {
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $('.nav-tabs a').click(function (e) {
      $(this).tab('show');
      var scrollmem = $('body').scrollTop();
      window.location.hash = this.hash;
      $('html,body').scrollTop(scrollmem);
    });
  };

  /**
   * Submit
   */
  $.kalibao.backend.product.View.prototype.submit = function ($button) {
    var self = this;

    if (window.FormData && ! this.validate(this.activeValidators, this.$main)) {
      var $form = $button.closest('form');
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
   * update the discount prices, rates and values
   * @param change input value changed (one of price, value or rate)
   * @param $container tab where the inputs are
   */
  $.kalibao.backend.product.View.prototype.updateDiscount = function (change, $container) {
    var $lines = $container.find("tr");
    for (var i = $lines.length - 1; i >= 1; i--) {
      var $curline = $lines.eq(i);
      var bprice   = parseFloat($curline.find("[disabled]").first().val());
      var $price   = $curline.find(".discount-price").first();
      var $value   = $curline.find(".discount-value").first();
      var $rate    = $curline.find(".discount-rate").first();
      var $fprice  = $curline.find(".discount-final-price").first();
      switch(change) {
        case "price":
          var value = bprice - parseFloat($price.val());
          var rate = (value / bprice)*100;
          $fprice.val($price.val());
          $value.val(Math.round(value*10000)/10000);
          $rate.val(Math.round(rate*100000)/100000);
          break;
        case "value":
          var value = parseFloat($value.val());
          var fprice = bprice - value;
          var rate = (value / bprice)*100;
          $fprice.val(Math.round(fprice*10000)/10000);
          $price.val(Math.round(fprice*10000)/10000);
          $rate.val(Math.round(rate*100000)/100000);
          break;
        case "rate":
          var rate = parseFloat($rate.val());
          var value = bprice * rate/100;
          var fprice = bprice - value;
          $fprice.val(Math.round(fprice*10000)/10000);
          $price.val(Math.round(fprice*10000)/10000);
          $value.val(Math.round(value*10000)/10000);
          break;
      }
    }
  };

  /**
   * calculates the sell prices and margins
   */
  $.kalibao.backend.product.View.prototype.calcPrices = function () {
    var $bpl = $("#buy-prices-table").find("tr");
    var $spl = $("#sell-prices-table").find("tr");
    var basePrice = parseFloat($("#base_price").val());
    var vat = parseFloat($("#priceTTC").data("vat"));

    for (var i = $bpl.length - 1; i >= 1; i--) {
      var buyPrice = parseFloat($bpl.eq(i).find("input").first().val());
      if (isNaN(buyPrice)) buyPrice = 0;
      var extraCost = 0;
      $spl.eq(i).find("span").each(function(){
        extraCost += parseFloat($(this).data("extracost"));
      });
      var priceTTC = Math.round((extraCost + basePrice) * (1+vat)*10000)/10000;
      var prices = [
        Math.round((extraCost + basePrice)*10000)/10000,
        priceTTC,
        Math.round((priceTTC / buyPrice)*100)/100,
        100-Math.round((buyPrice / priceTTC)*10000)/100 + " %"
      ];
      var $inputs = $spl.eq(i).find("input");
      $inputs.eq(0).val(prices[0]);
      $inputs.eq(1).val(prices[1]);
      $inputs.eq(2).val(prices[2]);
      $inputs.eq(3).val(prices[3]);
    }
  };

  /**
   * returns the value of the url parameter (similar to $_GET() in php)
   * @param name string The param name
   * @returns {*} The value of the url param
   */
  $.kalibao.backend.product.View.prototype.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
      return null;
    }
    else{
      return results[1] || 0;
    }
  };

  /**
   * Function to set the order value of variants after sorting them
   * @param $event Object The event triggered
   * @param $elem Object The ordered object
   */
  $.kalibao.backend.product.View.prototype.reorderVariants = function($event, $elem) {
    var $table = $elem['item'].parent();
    var order = 1;
    $table.find('tr').each(function(){
      $(this).find('.variant-order').eq(0).val(order++);
    })
  };

  /**
   * Function to add a cross sale to a variant
   * @param id int id of the current variant where cross sale is added
   */
  $.kalibao.backend.product.View.prototype.addCrossSellingLine = function(id) {
    $.post('/product/product/add-cross-sale', {
      variant1: id,
      variant2: $("#variant-selector").val()
    }, function(){location.reload()});
  };

  /**
   * Init the buttons to reset the form into their original state
   */
  $.kalibao.backend.product.View.prototype.initFormReset = function() {
    $('form').find(':input').each(function(i, elem) {
      var input = $(elem);
      input.data('initialState', input.val());
    });
    $('.reset-form').click(function(e) {
      e.preventDefault();
      $(this).closest('form').find(':input').each(function (i, elem) {
        var input = $(elem);
        input.val(input.data('initialState'));
      });
    });
  };

  /**
   * Init tne buttons to copy the first line of the table in the others
   */
  $.kalibao.backend.product.View.prototype.initCopyEvents = function () {
    var self = this;

    this.$main.find('.copy-first-double').click(function(){
      var col = $(this).parent().index();
      var $tbody = $(this).closest('table').find('tbody');
      var $firstLine = $tbody.find('tr').eq(0);
      var $secondLine = $tbody.find('tr').eq(1);
      $tbody.find('tr').each(function(){
        if ($(this).index() != 0 && $(this).index() != 1){
          if ($(this).index()%2 == 0) {
            $(this).find('td').eq(col).find('input').val(
              $firstLine.find('td').eq(col).find('input').val()
            )
          } else {
            $(this).find('td').eq(col-1).find('input').val(
              $secondLine.find('td').eq(col-1).find('input').val()
            )
          }
        }
      });
      switch (col){
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
  }

})(jQuery);
