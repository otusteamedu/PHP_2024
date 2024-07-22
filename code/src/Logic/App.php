<?

namespace Kuz\ChatSocket\Logic;

use Exception;

class App
{
  function run()
  {
    $settings = parse_ini_file('/data/config/config.ini');
    $serverName = $_SERVER['argv'][1];
    $serverSideSock = "/data/sockets/server.sock";
    $clientSideSock = "/data/sockets/client.sock";

    try {
      if ($serverName == "server") {
        $socket = new Server($serverSideSock);
        $serverFrom = $clientSideSock;
      } else if ($serverName == "client") {
        $socket = new Client($clientSideSock);
        $serverFrom = $serverSideSock;
      } else {
        new Exception("No found name");
      }

      $socket->createSocket();
      $socket->socketBind();
      $socket->startSocket($serverFrom);
    } catch (Exception $error) {
      echo $error;
    }
  }
}
