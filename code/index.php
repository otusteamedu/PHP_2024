<?php
echo "<h1>Hello, Tree!</h1>";

echo '<img src="img/300x450.webp" alt="poster"><br>';

$host = 'db';
$db = 'mydatabase';
$user = 'myuser';
$pass = 'mydatabase';
$charset = 'utf8';
$dsn = "pgsql:host=$host;dbname=$db;";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// SQL-запрос для вставки данных
$sql = "INSERT INTO mytable (name, age) VALUES (:name, :age)";
$stmt = $pdo->prepare($sql);

$name = 'Ivan Drago';
$age = 32;

$stmt->execute(['name' => $name, 'age' => $age]);

echo "Данные успешно добавлены!";
?>