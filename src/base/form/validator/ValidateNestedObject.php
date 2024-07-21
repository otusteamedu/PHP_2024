<?php

declare(strict_types=1);

namespace app\base\form\validator;

use app\base\form\BaseForm;
use DomainException;
use yii\validators\Validator;

class ValidateNestedObject extends Validator
{
    public string $nested_object_class;

    public $skipOnEmpty = false;

    public $params_to_nested_object;

    public function init(): void
    {
        if (!is_subclass_of($this->nested_object_class, BaseForm::class)) {
            throw new DomainException('nested_object_class is not implement BaseForm');
        }

        parent::init();
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute): void
    {
        $value = $model->{$attribute};

        /** @var BaseForm $class */
        $class = $this->nested_object_class;
        $paramsCallable = $this->params_to_nested_object;
        $paramsSub = [];
        if (\is_callable($paramsCallable) && !empty($params = $paramsCallable()) && \is_array($params)) {
            $paramsSub = $params;
        }

        $form = $class::loadForm($value, default_params: ['scenario' => $model->getScenario(), 'params_to_nested_object' => $paramsSub]);

        if ($form->hasErrors()) {
            $model->addError($attribute, $form->getErrors());
        }

        $model->{$attribute} = $form;
    }
}
