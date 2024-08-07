<?php

declare(strict_types=1);

/**
 * Require core files.
 */
require_once __DIR__ . '/../helpers.php';
/**
 * Setting path aliases.
 */
Yii::setAlias('@base', dirname(__DIR__, 2) . '/');
Yii::setAlias('@common', dirname(__DIR__, 2) . '/common');
Yii::setAlias('@api', dirname(__DIR__, 2) . '/api');
Yii::setAlias('@console', dirname(__DIR__, 2) . '/console');
