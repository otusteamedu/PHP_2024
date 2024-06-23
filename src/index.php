<?php

use ValidatorBrackets\Validator;

include __DIR__ . '/Validator.php';

if (isset($_POST['string'])) {
    Validator::validate($_POST['string']);
}
