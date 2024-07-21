<?php

declare(strict_types=1);

namespace app\base\form\validator;

use Yii;
use yii\validators\NumberValidator;

class SmartInteger extends NumberValidator
{
    public $integerOnly = true;

    public function validateAttribute($model, $attribute): void
    {
        $value = $model->{$attribute};

        if (\is_string($value)) {
            $this->addError($model, $attribute, Yii::t('yii', '{attribute} must be a number.'));
        }

        parent::validateAttribute($model, $attribute);
    }
}
