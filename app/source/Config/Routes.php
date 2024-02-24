<?php

namespace Pavelsergeevich\Hw6\Config;

/**
 * Роуты
 */
class Routes
{
    static function getRoutes(): array
    {
        $routes = [
            'email/validation' => [
                'controller' => 'Email',
                'action' => 'validation'
            ],
        ];

        return $routes;
    }
}