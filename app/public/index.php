<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
</head>

<body>
  <?php

  // testing redis
  $redis = new Redis();

  $redis->connect('redis', 6379);

  if ($redis->ping()) {
    echo "PONG" . PHP_EOL;
  }

  // testing memcached
  $memcached = new Memcached();
  $memcached->addServer('memcached', 11211);

  $key = 'time';

  $time = $memcached->get($key);

  if (!$time) {
    $memcached->set($key, date('G:i:s'), 5);
    $time = $memcached->get($key);
  }

  echo $time . PHP_EOL;

  // testing mysql
  try {
    $conn = new PDO('mysql:host=db;dbname=app_db', 'pozys', 'password');

    echo 'Database connection established!';
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  }

  echo PHP_EOL;

  $conn = null;
  ?>

</body>

</html>