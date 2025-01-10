<?
declare(strict_types=1);

use Ikachko\Hw14\DataMapper\ProductMapper;

require_once("vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$arProducts = [
    ["title" => "p1", "price" => 1, "remnant" => 1],
    ["title" => "p2", "price" => 10, "remnant" => 12],
    ["title" => "p3", "price" => 4, "remnant" => 5],
];

$pdo = new PDO($_ENV["DB_TYPE"] . ":" . "host=" . $_ENV["DB_HOST"] .";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PWD"]);
$mapper = new ProductMapper($pdo);
foreach ($arProducts as $arProduct) {
    $mapper->insert($arProduct);
}

$products = $mapper->findAll();

foreach ($products as $product) {
    echo $product . "\r\n";
    $mapper->delete($product);
}
