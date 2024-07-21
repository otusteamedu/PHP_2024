<?php

declare(strict_types=1);

namespace app\base\form;

use api\contracts\ErrorFormResponseInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @codeCoverageIgnore
 */
abstract class BaseForm extends Model implements ErrorFormResponseInterface
{
    /**
     * @return static
     */
    final public static function create(array $params = []): self
    {
        return new static($params);
    }

    /**
     * @return static
     */
    final public static function loadForm(array $params = [], bool $reset_error_to_default = false, array $default_params = []): self
    {
        $params_to_nested_object = ArrayHelper::remove($default_params, 'params_to_nested_object');
        $form = new static($default_params);

        if (!$form->load($params)) {
            $form->load($params, '');
        }

        if (!empty($params_to_nested_object) && \is_array($params_to_nested_object) && method_exists($form, 'paramsToNestedObjectSet')) {
            $form->paramsToNestedObjectSet($params_to_nested_object);
        }

        $form->validate();

        if ($reset_error_to_default && $form->hasErrors()) {
            $form->resetErrorToDefault($default_params);
        }

        return $form;
    }

    private function resetErrorToDefault(array $default_params = []): void
    {
        $default_model = $this::create($default_params);

        foreach ($this->getErrors() as $key => $value) {
            $this->{$key} = $default_model->{$key};
        }

        $this->clearErrors();
    }
}
