<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\helpers\Html;
?>
<?php if($crudEdit->hasErrors()): ?>
    <div class="alert alert-danger">
        <?= Html::errorSummary($crudEdit->models); ?>
    </div>
<?php endif; ?>