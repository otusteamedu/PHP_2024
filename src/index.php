<?php

declare(strict_types=1);

require_once __DIR__ . '/BracketException.php';
require_once __DIR__ . '/RequestHandler.php';
require_once __DIR__ . '/BracketValidator.php';
require_once __DIR__ . '/ResponseFormatter.php';

// Initialize the classes
$validator = new BracketValidator();
$responseFormatter = new ResponseFormatter();
$requestHandler = new RequestHandler($validator, $responseFormatter);

// Handle the request
$requestHandler->handle();
