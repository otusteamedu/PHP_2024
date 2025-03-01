<?php
require('vendor/autoload.php');
$openapi = \OpenApi\Generator::scan([__DIR__ . '/app/Infrastructure/Api/V1/Controllers']);
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();