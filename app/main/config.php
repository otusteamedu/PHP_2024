<?php
return [
    'name' => 'user',
    'defaultController' => 'user',
    'components' => [
        'db' => [
            'class' => \App\services\DB::class,
            'config' => [
                'driver' => 'mysql',
                'host' => 'db',
                'db' => 'onlineShop',
                'charset' => 'UTF8',
                'username' => 'user',
                'password' => 'secret',
                'port' => '3306'
            ],
        ],
        'render' => [
            'class' => \App\services\renders\TwigRender::class,
        ],
        'userRepository' => [
            'class' => \App\Repositories\UserRepository::class,
        ],
        'goodRepository' => [
            'class' => \App\Repositories\GoodRepository::class,
        ],
        'orderRepository' => [
            'class' => \App\Repositories\OrderRepository::class,
        ],
        'CRUDService' => [
            'class' => \App\services\CRUDService::class,
        ],
        'orderService' => [
            'class' => \App\services\OrderService::class,
        ],
        'basketService' => [
            'class' => \App\services\BasketService::class,
        ],
        'goodService' => [
            'class' => \App\services\GoodService::class,
        ],
        'userService' => [
            'class' => \App\services\UserService::class,
        ],
        'basketRepository' => [
            'class' => \App\Repositories\BasketRepository::class,
        ],
        'basketController' => [
            'class' => \App\Controllers\BasketController::class,
        ],
        'goodAuthRepository' => [
            'class' => \App\Repositories\GoodAuthRepository::class,
        ],
        'userAuthRepository' => [
            'class' => \App\Repositories\UserAuthRepository::class,
        ],
        'orderAuthRepository' => [
            'class' => \App\Repositories\OrderAuthRepository::class,
        ],
        'goodAdminRepository' => [
            'class' => \App\Repositories\GoodAdminRepository::class,
        ],
        'userAdminRepository' => [
            'class' => \App\Repositories\UserAdminRepository::class,
        ],
        'orderAdminRepository' => [
            'class' => \App\Repositories\OrderAdminRepository::class,
        ]



    ],

];
