<?php
// set default encoding
mb_internal_encoding('UTF-8');

// define aliases
Yii::setAlias('@kalibao', dirname(dirname(__DIR__)));
Yii::setAlias('@kalibao/views', '@kalibao/common/components/views');

// override validators
\yii\validators\Validator::$builtInValidators['compare'] = 'kalibao\common\components\validators\CompareValidator';