<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use Irayu\Hw6;

(new Hw6\App())->run([
    'wrongem,ail@mail.ru', 'ri-ght.em1ail@gmail.com', 'really@bad@email', 'test@example.com',
]);
