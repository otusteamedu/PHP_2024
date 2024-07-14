<?

namespace Kuz\ChatSocket\Logic;

use Exception;

class App
{
  function run()
  {
    $serverName = $_SERVER['argv'][1];
    try {
      $server_side_sock = "/data/sockets/server.sock";
      $client_side_sock =  "/data/sockets/client.sock";

      $socket = self::createSocket($serverName);

      if ($serverName == "server") {
        Server::sendRequest($socket, $server_side_sock, $client_side_sock);
      } else if ($serverName == "client") {
        Client::acceptQuery($socket, $server_side_sock, $client_side_sock);
      } else {
        new Exception("No found name");
      }
    } catch (Exception $error) {
      echo $error;
    }
  }

  private static function createSocket($serverName)
  {
    if ($serverName != "server"  && $serverName != "client") {
      throw new Exception("Incorrectly specified name server");
    }
    if (!extension_loaded('sockets')) {
      throw new Exception("The sockets extension is not loaded");
    }

    $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

    if (!$socket) {
      throw new Exception('Unable to create AF_UNIX socket');
    }

    return $socket;
  }
}
