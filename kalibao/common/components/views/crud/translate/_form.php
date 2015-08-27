<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use yii\helpers\Url;
?>
<form method="POST" action="<?= Url::to(['translate'] + $crudTranslate->getPk()); ?>">
    <?= $this->render('crud/translate/_grid', ['crudTranslate' => $crudTranslate], $this->context); ?>
</form>