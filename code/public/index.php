<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Otus\Balancer\StringCheker\StringCheker;

(new StringCheker())->check($_POST["string"]);

echo "<br>" . date("Y-m-d H:i:s") . "<br>";
echo "Processed by: " . $_SERVER['HOSTNAME'];
