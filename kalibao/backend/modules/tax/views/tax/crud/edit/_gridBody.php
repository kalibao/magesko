<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;
use kalibao\common\components\crud\SimpleValueField;
use kalibao\common\components\helpers\Countries;
use kalibao\common\models\taxCountry\TaxCountry;

?>
<tbody>
<?php foreach ($crudEdit->items as $itemField): ?>
  <tr>
    <th><?= $itemField->label !== null ? $itemField->label : $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
    <td>
      <?php if ($itemField instanceof InputField): ?>
        <div
          class="form-group<?= ($hasError = $itemField->model->hasErrors($itemField->attribute)) ? ' has-error' : ''; ?>">
          <?php if (!empty($itemField->data)): ?>
            <?= call_user_func_array([
              '\kalibao\common\components\helpers\Html',
              $itemField->type
            ],
              [
                $itemField->model,
                $itemField->attribute,
                $itemField->data,
                $itemField->options
              ]); ?>
          <?php else: ?>
            <?= call_user_func_array([
              '\kalibao\common\components\helpers\Html',
              $itemField->type
            ],
              [
                $itemField->model,
                $itemField->attribute,
                $itemField->options
              ]); ?>
          <?php endif; ?>
          <div class="control-label help-inline"></div>
        </div>
      <?php elseif ($itemField instanceof DateRangeField): ?>
        <div class="form-group">
          <?= Yii::t('kalibao', 'date_range_between'); ?>
          <?= call_user_func_array([
            '\kalibao\common\components\helpers\Html',
            $itemField->start->type
          ],
            [
              $itemField->start->model,
              $itemField->start->attribute,
              $itemField->start->options
            ]); ?>
          <?= Yii::t('kalibao', 'date_range_separator'); ?>
          <?= call_user_func_array([
            '\kalibao\common\components\helpers\Html',
            $itemField->end->type
          ],
            [
              $itemField->end->model,
              $itemField->end->attribute,
              $itemField->end->options
            ]); ?>
          <div class="control-label help-inline"></div>
        </div>
      <?php elseif ($itemField instanceof SimpleValueField): ?>
        <?= $itemField->value; ?>
      <?php endif; ?>
    </td>
  </tr>
<?php endforeach; ?>
<tr>
  <td colspan="2">
    <h3 data-toggle="collapse" data-target="#tax-countries"
      style="cursor: pointer;">Choisir les pays concernés (<span
        id="selected-countries"></span>)</h3>
    <div id="tax-countries" class="collapse"
      style="-webkit-column-width: 150px">
      <?php foreach (Countries::getAllCountriesByContinent() as $continent => $countries): ?>
        <p>
          <input type="checkbox" class="continent-check" id="<?= $continent ?>">
          <b data-toggle="collapse" data-target="#<?= $continent ?>-countries"
            style="cursor: pointer;"><?= Yii::t('kalibao.backend',
              'label_continent_' . $continent) ?></b>
        </p>
        <div style="margin-left: 15px;" class="collapse inner"
          id="<?= $continent ?>-countries">
          <?php foreach ($countries as $country): ?>
            <p>
              <label>
                <input type="checkbox" name="country[]"
                  class="country-check continent-<?= $continent ?>"
                  id="<?= $country ?>"
                  value="<?= $country ?>" <?= TaxCountry::findOne([
                  'country_id' => $country,
                  'tax_id'     => $crudEdit->models['main']->id
                ]) ? 'checked' : '' ?>>
                <?= $crudEdit->countryTranslations[$country] ?>
              </label>
            </p>
          <?php endforeach ?>
          <hr>
        </div>
      <?php endforeach; ?>
    </div>
  </td>
</tr>
</tbody>
<script>
  (function ($) {
    $('.continent-check').change(function () {
      var id = $(this).attr('id');
      $('.continent-' + id).prop('checked', $(this).prop('checked'));
      $('#selected-countries').html(
        $('.country-check:checked').size() + '/' + $('.country-check').size()
      );
    });
    $('.country-check').change(function () {
      $('#selected-countries').html(
        $('.country-check:checked').size() + '/' + $('.country-check').size()
      );

      var regExp = /(continent-..)/gm;
      var continentClass = regExp.exec($(this).attr("class"))[1];
      var continentId = continentClass.split('-')[1];
      var $continentList = $('#' + continentId);
      $continentList.prop(
        'indeterminate', ($('.continent-' + continentId + ':checked').size() != 0)
      )
    }).change();
  })(jQuery)
</script>
<style>
  *[data-toggle='collapse'][aria-expanded='true']:after {
    margin-left: 5px;
    content: '\25b2';
  }

  *[data-toggle='collapse']:after,
  *[data-toggle='collapse'][aria-expanded='false']:after {
    margin-left: 5px;
    content: '\25bc';
  }

  .collapse.inner, .collapsing.inner {
    background-color: #eeeeee;
  }
</style>