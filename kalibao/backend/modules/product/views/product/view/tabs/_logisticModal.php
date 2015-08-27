<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */
use kalibao\common\models\logisticStrategy\LogisticStrategy;
?>

<div class="modal fade" data-id="<?= $variant->logistic_strategy_id ?>" id="logistic-popup-<?= $variant->logistic_strategy_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-main">
                    <section class="content-header">
                        <a class="btn pull-right description-update" data-dismiss="modal">×</a>
                        <h1><?= Yii::t('kalibao.backend', 'label_logistic_strategy') ?></h1>
                    </section>
                    <section class="content">
                        <div class="box box-primary">
                            <div class="box-body">
                                <select class="select-strategy">
                                    <option <?= ($variant->logisticStrategy->strategy == LogisticStrategy::STOCKOUT)? 'selected':'' ?> data-id="#strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::STOCKOUT ?>" value="<?= LogisticStrategy::STOCKOUT ?>">STOCKOUT</option>
                                    <option <?= ($variant->logisticStrategy->strategy == LogisticStrategy::PREORDER)? 'selected':'' ?> data-id="#strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::PREORDER ?>" value="<?= LogisticStrategy::PREORDER ?>">PREORDER</option>
                                    <option <?= ($variant->logisticStrategy->strategy == LogisticStrategy::REAL_STOCK)? 'selected':'' ?> data-id="#strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::REAL_STOCK ?>" value="<?= LogisticStrategy::REAL_STOCK ?>">REAL_STOCK</option>
                                    <option <?= ($variant->logisticStrategy->strategy == LogisticStrategy::DIRECT_DELIVERY)? 'selected':'' ?> data-id="#strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::DIRECT_DELIVERY ?>" value="<?= LogisticStrategy::DIRECT_DELIVERY ?>">DIRECT_DELIVERY</option>
                                    <option <?= ($variant->logisticStrategy->strategy == LogisticStrategy::JUST_IN_TIME)? 'selected':'' ?> data-id="#strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::JUST_IN_TIME ?>" value="<?= LogisticStrategy::JUST_IN_TIME ?>">JUST_IN_TIME</option>
                                    <option <?= ($variant->logisticStrategy->strategy == LogisticStrategy::TEMPORARY_STOCKOUT)? 'selected':'' ?> data-id="#strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::TEMPORARY_STOCKOUT ?>" value="<?= LogisticStrategy::TEMPORARY_STOCKOUT ?>">TEMPORARY_STOCKOUT</option>
                                </select>

                                <!-- Stockout data -->
                                <div style="display:none" id="strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::STOCKOUT ?>"><?= Yii::t('kalibao.backend', 'label_logistic_strategy_no_option') ?></div>

                                <!-- Preorder data -->
                                <div style="display:none" id="strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::PREORDER ?>">
                                    <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_delivery_date') ?></label><input value="<?= $variant->logisticStrategy->delivery_date ?>" name="strategy[<?= LogisticStrategy::PREORDER ?>][date]" class="form-control input-sm date-picker" type="text"/><br/>
                                    <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_message') ?></label>
                                    <textarea name="strategy[<?= LogisticStrategy::PREORDER ?>][message]" class="form-control wysiwyg-textarea"><?= ($variant->logisticStrategyI18n)? $variant->logisticStrategyI18n->message:'' ?></textarea>
                                </div>

                                <!-- Real stock data -->
                                <div style="display:none" id="strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::REAL_STOCK ?>">
                                    <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_alert_stock') ?></label><input value="<?= $variant->logisticStrategy->alert_stock ?>" name="strategy[<?= LogisticStrategy::REAL_STOCK ?>][alert]" class="form-control input-sm" type="number"/><br/>
                                    <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_alternative_strategy') ?></label>
                                    <select name="strategy[<?= LogisticStrategy::REAL_STOCK ?>][alternative]" class="select-alternative-strategy">
                                        <option <?= ($variant->logisticStrategy->alternativeStrategy == LogisticStrategy::STOCKOUT)? 'selected':'' ?> data-id="#alternative-strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::STOCKOUT ?>" value="<?= LogisticStrategy::STOCKOUT ?>">STOCKOUT</option>
                                        <option <?= ($variant->logisticStrategy->alternativeStrategy == LogisticStrategy::DIRECT_DELIVERY)? 'selected':'' ?> data-id="#alternative-strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::DIRECT_DELIVERY ?>" value="<?= LogisticStrategy::DIRECT_DELIVERY ?>">DIRECT_DELIVERY</option>
                                        <option <?= ($variant->logisticStrategy->alternativeStrategy == LogisticStrategy::JUST_IN_TIME)? 'selected':'' ?> data-id="#alternative-strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::JUST_IN_TIME ?>" value="<?= LogisticStrategy::JUST_IN_TIME ?>">JUST_IN_TIME</option>
                                    </select>
                                    <div style="display:none" id="alternative-strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::STOCKOUT ?>">
                                        <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_message') ?></label>
                                        <textarea name="strategy[<?= LogisticStrategy::REAL_STOCK ?>][<?= LogisticStrategy::STOCKOUT ?>][message]" class="form-control wysiwyg-textarea"><?= ($variant->logisticStrategyI18n)? $variant->logisticStrategyI18n->message:'' ?></textarea>
                                    </div>
                                    <div style="display:none" id="alternative-strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::DIRECT_DELIVERY ?>">
                                        <label><?= Yii::t('kalibao.backend', 'label_supplier_id') ?></label><br/><input value="<?= $variant->logisticStrategy->supplier_id ?>" name="strategy[<?= LogisticStrategy::REAL_STOCK ?>][<?= LogisticStrategy::DIRECT_DELIVERY ?>][supplier]" class="form-control input-sm input-ajax-select" type="hidden"/><br/>
                                        <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_additional_delay') ?></label><input value="<?= $variant->logisticStrategy->additional_delay ?>" name="strategy[<?= LogisticStrategy::REAL_STOCK ?>][<?= LogisticStrategy::DIRECT_DELIVERY ?>][delay]" class="form-control input-sm" type="number"/>
                                    </div>
                                    <div style="display:none" id="alternative-strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::JUST_IN_TIME ?>">
                                        <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_additional_delay') ?></label><input value="<?= $variant->logisticStrategy->additional_delay ?>" name="strategy[<?= LogisticStrategy::REAL_STOCK ?>][<?= LogisticStrategy::JUST_IN_TIME ?>][delay]" class="form-control input-sm" type="number"/>
                                    </div>
                                </div>

                                <!-- Direct delivery data -->
                                <div style="display:none" id="strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::DIRECT_DELIVERY ?>">
                                    <label><?= Yii::t('kalibao.backend', 'label_supplier_id') ?></label><br/><input value="<?= $variant->logisticStrategy->supplier_id ?>" name="strategy[<?= LogisticStrategy::DIRECT_DELIVERY ?>][supplier]" class="form-control input-sm input-ajax-select" type="hidden"/><br/>
                                    <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_additional_delay') ?></label><input value="<?= $variant->logisticStrategy->additional_delay ?>" name="strategy[<?= LogisticStrategy::DIRECT_DELIVERY ?>][delay]" class="form-control input-sm" type="number"/>
                                </div>

                                <!-- Just in time data -->
                                <div style="display:none" id="strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::JUST_IN_TIME ?>">
                                    <label><?= Yii::t('kalibao.backend', 'label_logistic_strategy_additional_delay') ?></label><input value="<?= $variant->logisticStrategy->additional_delay ?>" name="strategy[<?= LogisticStrategy::JUST_IN_TIME ?>][delay]" class="form-control input-sm" type="number"/>
                                </div>

                                <!-- Temporary stockout data -->
                                <div style="display:none" id="strategy_<?= $variant->logistic_strategy_id . '_' . LogisticStrategy::TEMPORARY_STOCKOUT ?>"><?= Yii::t('kalibao.backend', 'label_logistic_strategy_no_option') ?></div>

                                <div class="row">
                                    <button class="btn btn-primary save-logistic"><?= Yii::t('kalibao', 'btn_save') ?></button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>