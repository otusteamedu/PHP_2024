<?php

declare(strict_types=1);

use Dotenv\Dotenv;

/**
 * Require helpers.
 */

/**
 * Load application environment from .env file.
 */
$dotenv = new Dotenv(dirname(__DIR__));
$dotenv->load();
/**
 * Init application constants.
 */
defined('YII_DEBUG') || define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') || define('YII_ENV', env('YII_ENV', 'prod'));
defined('YII_PROFILE_TEST') || define('YII_PROFILE_TEST', env('YII_PROFILE') === 'test');
defined('YII_PROFILE_PROD') || define('YII_PROFILE_PROD', env('YII_PROFILE') === 'prod');
defined('YII_SERVER_TEST') || define('YII_SERVER_TEST', env('YII_SERVER_TEST'));
defined('YII_DEBUG_PANEL') || define('YII_DEBUG_PANEL', env('YII_DEBUG_PANEL'));
