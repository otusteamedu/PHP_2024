<?php

use Consumer\MessageProcessor;

require __DIR__ . '/../vendor/autoload.php';

$processor = new MessageProcessor();
try {
    $processor->consume();
} catch (Exception $e) {
    exit($e->getMessage());
}
