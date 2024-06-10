<?php

declare(strict_types=1);

$app = require_once __DIR__ . '/../config/bootstrap.php';

$app['processor.interface']->processQueue();
