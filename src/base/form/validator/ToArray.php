<?php

declare(strict_types=1);

namespace app\base\form\validator;

use yii\validators\Validator;

class ToArray extends Validator
{
    public $skipOnEmpty = false;

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute): void
    {
        $value = $model->{$attribute};

        if (\is_array($value)) {
            return;
        }

        if (null === $value) {
            $model->{$attribute} = [];
            return;
        }

        if (\is_string($value) && str_contains($value, ',')) {
            $model->{$attribute} = explode(',', $value);
            return;
        }

        $model->{$attribute} = [$value];
    }
}
