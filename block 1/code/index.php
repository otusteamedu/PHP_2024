<?php

echo "Redis block";
echo "<br><br><br>";
$redis = new Redis();
$redis->connect('redis', 6379);
echo "Connection to server sucessfully <br>";
$redis->set("tutorial-name", "Redis tutorial");
echo "Stored string in redis:: " . $redis->get("tutorial-name") . "<br>";
echo "-------------------------------------------------------------------";
echo "<br><br><br>";

echo "Memcached block";
echo "<br><br><br>";
$mc = new Memcached();                                                             
$mc->addServer("mymemcached", 11211);                                              
$mc->add("key1", "value1");                                                        
$mc->add("key2", "value2");                                                        
$mc->add("key3", "value3");                                                        
echo "key1 : " . $mc->get("key1") . "<br>";                                          
echo "key2 : " . $mc->get("key2") . "<br>";                                          
echo "key3 : " . $mc->get("key3") . "<br>"; 
echo "-------------------------------------------------------------------";
echo "<br><br><br>";

echo "PostgreSQL block";
echo "<br><br><br>";
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");
$db = getenv("DB_NAME");
try {
  $pdo = new \PDO("pgsql:host=$host;dbname=$db", $user, $pass);
  echo "Подключение к базе данных установлено! <br>";
} catch (PDOException $exception) {
  echo "Ошибка при подключении к базе данных<br><b>{$exception->getMessage()}</b><br>";
}

echo "-------------------------------------------------------------------";
echo "<br><br><br>";
phpinfo();