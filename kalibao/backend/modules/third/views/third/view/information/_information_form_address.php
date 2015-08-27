<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<form method="POST" action="<?= $crudAddress->action; ?>">
    <table class="table table-condensed">
        <?= $this->render('view/information/_informationBody_address', compact($listCompact, 'listCompact'), $this->context); ?>
        <?= $this->render('view/information/_informationFoot_address', compact($listCompact, 'listCompact'), $this->context); ?>
    </table>
</form>