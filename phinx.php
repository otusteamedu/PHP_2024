<?php

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => 'sqlite',
                'name' => './db/database',
            ],
            'development' => [
                'adapter' => 'sqlite',
                'name' => './db/database',
            ],
            'testing' => [
                'adapter' => 'sqlite',
                'name' => './db/database',
            ]
        ],
        'version_order' => 'creation'
    ];
