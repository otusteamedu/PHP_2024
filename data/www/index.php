<?php

//тест подключения к БД (БД "mysite" была предварительно создана)
try {
    $conn = new PDO("mysql:host=mysql; dbname=" . getenv('MYSQL_DB'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    echo "<table><tr><th>Id</th><th>Name</th></tr>";
    while ($row = $result->fetch()) {
        echo "<tr>";
        echo "<td>" . $row["Id"] . "</td>";
        echo "<td>" . $row["Name"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
//END

//тест memcached
echo '<h4>тест memcached</h4>';
$memcached = new Memcached;
$memcached->addServer('memcached', 11211) or die("Could not connect");
$memcached->set('hello', "Yes!");
var_dump($memcached->get('hello'));
echo '<br>';
var_dump($memcached->get('by'));
//END

//тест redis
echo '<h4>тест redis</h4>';
$redis = new Redis([
    'host' => 'redis',
]);
$redis->set('yes', 'RedisYes');
$resRedisYes = $redis->get('yes');
$resRedisNo = $redis->get('no');
var_dump($resRedisYes);
echo '<br>';
var_dump($resRedisNo);
//END

//вывод phpinfo
echo phpinfo();
//END