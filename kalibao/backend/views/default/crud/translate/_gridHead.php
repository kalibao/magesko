<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use \kalibao\common\components\helpers\Html;
?>
<thead>
<tr class="form-inline">
    <th></th>
    <?php foreach($crudTranslate->languages as $language): ?>
        <th><?= Html::labelI18n($language); ?></th>
    <?php endforeach; ?>
</tr>
</thead>