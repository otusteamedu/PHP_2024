<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Otus\App\EmailCheker\EmailCheker;

(new EmailCheker())->run();
