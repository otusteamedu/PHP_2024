<?php

declare(strict_types=1);

namespace Otus\Balancer;

use Otus\Balancer\BracketsValidator\BracketsValidator;

require __DIR__ . '/../vendor/autoload.php';


$str = $_POST["string"];
if ($str) {
	$bracketsValidator = new BracketsValidator();
	$strIsValid = $bracketsValidator->validate($str);
	if ($strIsValid) {
		echo "string is <b>VALID</b>";
	} else {
		http_response_code(400);
		echo 'string is <b>INVALID</b>';
	}
} else {
	http_response_code(400);
	echo "string is <b>NOT PASSED</b>";
}
echo "<br>" . date("Y-m-d H:i:s") . "<br>";
echo "Processed by: " . $_SERVER['HOSTNAME'];
