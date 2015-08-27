<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

use \yii\widgets\LinkPager;
?>
<?=
LinkPager::widget([
    'options' => [
        'class' => 'pagination pagination-sm pull-right'
    ],
    'pagination' => $crudList->dataProvider->pagination,
    'firstPageLabel' => Yii::t('kalibao', 'first_page'),
    'lastPageLabel' => Yii::t('kalibao', 'last_page')
]);
?>