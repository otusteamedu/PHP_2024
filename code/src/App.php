<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11;

use PDO;

class App
{
    public function run()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=hw11', 'root', '');
        $productMapper = new ProductMapper($pdo);
        $result = $productMapper->findAll();
    }
}