<?php
declare(strict_types=1);

define('HOST',getenv('TEST_RABBITMQ_HOST')?getenv('TEST_RABBITMQ_HOST'):'rabbitmq');
define('PORT',getenv('TEST_RABBITMQ_PORT')?getenv('TEST_RABBITMQ_PORT'):5672);
define('USER',getenv('TEST_RABBITMQ_USER')?getenv('TEST_RABBITMQ_USER'):'user');
define('PASS',getenv('TEST_RABBITMQ_PASS')?getenv('TEST_RABBITMQ_PASS'):'pass');