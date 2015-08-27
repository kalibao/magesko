<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\validators;

use yii\base\Model;
use kalibao\common\components\crud\InputField;
use kalibao\common\components\crud\DateRangeField;

/**
 * Class ClientSideValidator implements the common methods and properties to generate client side validators.
 *
 * @package kalibao\common\components\validators
 * @version 1.O
 * @author Kévin Walter <walkev13@gmail.com>
 */
class ClientSideValidator
{
    /**
     * Get client side validators based from a list of ItemField
     * @param \kalibao\common\components\crud\ItemField[] Item field
     * @param \yii\web\View $view Current view
     * @return array
     */
    public static function getClientValidators(array $itemFields, $view)
    {
        $validators = [];
        foreach ($itemFields as $filter) {
            if ($filter instanceof InputField) {
                $js = self::getClientValidatorsAttribute($filter->model, $filter->attribute, $view);
                if (! empty($js)) {
                    $validators[$filter->attribute] = [
                        'id' => $filter->id,
                        'js' => $js
                    ];
                }
            } elseif ($filter instanceof DateRangeField) {
                $js = self::getClientValidatorsAttribute($filter->start->model, $filter->start->attribute, $view);
                if (! empty($js)) {
                    $validators[$filter->start->attribute] = [
                        'id' => $filter->start->id,
                        'js' => $js
                    ];
                }
                $js = self::getClientValidatorsAttribute($filter->end->model, $filter->end->attribute, $view);
                if (! empty($js)) {
                    $validators[$filter->end->id] = [
                        'id' => $filter->end->id,
                        'js' => $js
                    ];
                }
            }
        }

        return $validators;
    }

    /**
     * Get client side validators attribute
     * @param \yii\base\Model $model Model
     * @param string $attribute Attribute name
     * @param \yii\web\View $view Current view
     * @return array
     */
    public static function getClientValidatorsAttribute(Model $model, $attribute, $view)
    {
        $validators = [];
        foreach ($model->getActiveValidators($attribute) as $validator) {
            /* @var $validator \yii\validators\Validator */
            $js = $validator->clientValidateAttribute($model, $attribute, $view);
            if ($validator->enableClientValidation && $js != '') {
                if ($validator->whenClient !== null) {
                    $js = "if (({$validator->whenClient})(attribute, value)) { $js }";
                }
                $validators[] = $js;
            }
        }
        return $validators;
    }
}