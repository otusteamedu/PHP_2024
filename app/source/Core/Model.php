<?php

namespace Pavelsergeevich\Hw6\Core;

abstract class Model
{
    const MODELS_NAMESPACE = '\\Pavelsergeevich\\Hw6\\Models\\';
    const MODELS_ENDING = 'Model';
    public array $additionalParams;
    public array $requestParams;

    public function __construct(?array $requestParams = [], ?array $additionalParams = [])
    {
        $this->requestParams = $requestParams;
        if ($additionalParams) {
            $this->additionalParams = $additionalParams;
        }

    }

}