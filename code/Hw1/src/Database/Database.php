<?php

namespace Dmigrishin\FirstHomework\Database;

class Database extends \PDO
{

//database connection variables
static private $host   = null;
static private $dbname = null;
static private $user   = null;
static private $pass   = null;

private static $instance = null;

//get the singleton instance
static function get() {
  if (self::$instance!=null) return self::$instance;
  
  try {
    self::$pass = $_ENV['MYSQL_ROOT_PASSWORD'];
    self::$host = $_ENV['MYSQL_CONTAINER_IP'];
    self::$user = $_ENV['MYSQL_USER'];
    self::$dbname = $_ENV['MYSQL_DATABASE'];

    self::$instance = new Database("mysql:host=".self::$host.";dbname=".self::$dbname, self::$user, self::$pass);
    return self::$instance;
  }
  catch(PDOException $e) {
      print $e->getMessage();
      return null;
  }
}

public static function testmysql(){

  $db = Database::get();

  if($db<>null){
      echo "Database is connected" . "<br/>";
  }

}

}
?>