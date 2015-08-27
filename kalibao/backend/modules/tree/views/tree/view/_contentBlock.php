<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

$this->registerJs("
    new $.kalibao.backend.tree.View({
        id: '".sha1($title)."',
        treeData: ". $json ."
    });
");
?>

<div class="content-block" id="<?= sha1($title) ?>">
    <div class="content-dynamic"></div>
    <div class="content-main">
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <fieldset>
                        <legend><?= $title ?></legend>
                        <div id="tree"></div>
                    </fieldset>
                </div>
                <div class="col-md-9">
                    <fieldset>
                        <legend id="branch-title">Sélectionner une branche</legend>
                        <div id="branch-container"></div>
                    </fieldset>
                </div>
            </div>
        </section>
    </div>
</div>