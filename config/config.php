<?php
return [
    'repository' => 'elastic', // Либо 'another_db' для другой базы данных
    'elasticsearch' => [
        'hosts' => ['localhost:9200'],
        'index' => 'books',
    ],
];
