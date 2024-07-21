<?php

declare(strict_types=1);

/**
 * Yii2 Shortcuts.
 * @author Eugene Terentev <eugene@terentev.net>
 * -----
 * This file is just an example and a place where you can add your own shortcuts,
 * it doesn't pretend to be a full list of available possibilities
 * -----
 * @param mixed $view
 * @param mixed $params
 */

use app\base\entity\Id;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * @param string $view
 * @param array $params
 * @return string
 */
function render($view, $params = [])
{
    return Yii::$app->controller->render($view, $params);
}

/**
 * @param int $statusCode
 * @param mixed $url
 * @return Response
 */
function redirect($url, $statusCode = 302)
{
    return Yii::$app->controller->redirect($url, $statusCode);
}

/**
 * @param string $key
 * @param mixed $default
 */
function env($key, $default = false): mixed
{
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
    }

    return $value;
}

/**
 * @param int $depth
 * @param bool $highlight
 * @param bool $die
 * @param mixed $var
 */
function vd($var, $depth = 100, $highlight = true, $die = true): void
{
    VarDumper::dump($var, $depth, $highlight);
    if ($die) {
        exit;
    }
}

function to_array($val): array
{
    return is_array($val) ? $val : [];
}

function object_to_array($object): array
{
    $reflectionClass = new ReflectionClass($object::class);
    $array = [];
    foreach ($reflectionClass->getProperties() as $property) {
        $property->setAccessible(true);
        $value = $property->getValue($object);
        if ($value instanceof BackedEnum) {
            $value = $value->value;
        }

        if ($value instanceof Id) {
            $value = $value->getValue();
        }

        if ($value instanceof DateTimeImmutable) {
            $value = $value->format('U');
        }

        if (is_object($value)) {
            $value = object_to_array($value);
        }

        $array[$property->getName()] = $value;
        $property->setAccessible(false);
    }
    return $array;
}

