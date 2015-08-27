<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<section class="content crud-translate">
    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col-xs-12">
                    <form class="form-inline form-group-language" type="GET" action="<?= Url::to(['translate'] + $crudTranslate->requestParams) ?>">
                        <label class="control-label"><?= Yii::t('kalibao', 'select_group_language'); ?> :</label>
                        <select class="form-control" name="language_group_id">
                            <?php foreach ($crudTranslate->languagesGroups as $languageGroup): ?>
                                <option value="<?= $languageGroup->language_group_id ?>" <?= $languageGroup->language_group_id == $crudTranslate->languageGroupId ? 'selected':'' ?>><?= $languageGroup->title ?></option>
                            <?php endforeach ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('crud/translate/_success', ['crudTranslate' => $crudTranslate], $this->context); ?>
                    <?= $this->render('crud/translate/_form', ['crudTranslate' => $crudTranslate], $this->context); ?>
                </div>
            </div>
        </div>
    </div>
</section>