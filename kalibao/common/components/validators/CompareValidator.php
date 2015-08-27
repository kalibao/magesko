<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\validators;

use Yii;
use yii\helpers\Html;
use yii\validators\ValidationAsset;

/**
 * Class CompareValidator overload default CompareValidator component in order to modify client validator
 *
 * @package kalibao\common\components\validators
 * @version 1.O
 * @author Kévin Walter <walkev13@gmail.com>
 */
class CompareValidator extends \yii\validators\CompareValidator
{
    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = [
            'operator' => $this->operator,
            'type' => $this->type,
        ];

        if ($this->compareValue !== null) {
            $options['compareValue'] = $this->compareValue;
            $compareValue = $this->compareValue;
        } else {
            $compareAttribute = $this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
            $compareValue = $model->getAttributeLabel($compareAttribute);
            $options['compareAttribute'] = Html::getInputId($model, $compareAttribute);
        }

        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        $options['message'] = Yii::$app->getI18n()->format($this->message, [
            'attribute' => $model->getAttributeLabel($attribute),
            'compareAttribute' => $compareValue,
            'compareValue' => $compareValue,
        ], Yii::$app->language);

        ValidationAsset::register($view);

        return 'yii.validation.compare(attribute, value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}
