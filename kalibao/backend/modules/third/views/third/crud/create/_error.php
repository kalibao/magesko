<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use kalibao\common\components\helpers\Html;
?>
<?php if ($crudEdit->hasErrors()): ?>
    <div class="callout callout-danger">
        <?= Html::errorSummary($crudEdit->models); ?>
    </div>
<?php endif; ?>