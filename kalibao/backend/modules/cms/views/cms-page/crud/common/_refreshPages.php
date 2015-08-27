<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<div class="cache-result">
    <?php if ($success): ?>
    <div class="callout callout-success">
        <h4><?= Yii::t('kalibao.backend', 'cache_refresh_success'); ?></h4>
    </div>
    <?php else: ?>
        <div class="callout callout-danger">
            <h4><?= Yii::t('kalibao.backend', 'cache_refresh_error'); ?></h4>
        </div>
    <?php endif; ?>
</div>