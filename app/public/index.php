<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

use PavelMiasnov\MediaMonitoring\Kernel;

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
