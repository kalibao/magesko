<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<?php if ($crudEdit->isSaved()): ?>
    <div class="callout callout-success">
        <h4><?= Yii::t('kalibao', 'is_saved'); ?></h4>
    </div>
<?php endif; ?>