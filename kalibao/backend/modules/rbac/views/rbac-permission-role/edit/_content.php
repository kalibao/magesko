<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
?>
<section class="content crud-edit">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('_success', ['isSaved' => $isSaved]); ?>
                    <?= $this->render('_error', ['models' => $models, 'hasErrors' => $hasErrors]); ?>
                    <?= $this->render('_form', ['models' => $models]); ?>
                </div>
            </div>
        </div>
    </div>
</section>