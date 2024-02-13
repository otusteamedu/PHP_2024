<?php

use App\Models\Customer;

require_once './vendor/autoload.php';

$customer = new Customer('Сидоров', 'Пётр', 'Николаевич');
echo $customer->nameFormat()->short() . PHP_EOL; // Сидоров П.
echo $customer->nameFormat()->fullShort() . PHP_EOL; // Сидоров П.Н.
echo $customer->nameFormat()->long() . PHP_EOL; // Сидоров Пётр
echo $customer->nameFormat()->fullLong() . PHP_EOL; // Сидоров Пётр Николаевич