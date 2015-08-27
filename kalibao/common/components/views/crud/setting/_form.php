<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<form method="POST" action="<?= Url::to(['settings']); ?>">
    <?= $this->render('crud/setting/_grid', ['crudSetting' => $crudSetting], $this->context); ?>
</form>