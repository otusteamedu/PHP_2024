<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use App\Controller\Console\Controller;

(new Controller())->run($argv);
