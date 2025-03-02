<?php
require('vendor/autoload.php');
$openapi = \OpenApi\Generator::scan([__DIR__ . '/app/Infrastructure/Controllers/Api']);
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();