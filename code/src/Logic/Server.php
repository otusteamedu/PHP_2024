<?

namespace Kuz\ChatSocket\Logic;

use Exception;

class Server
{
  static function sendRequest($socket, $server_side_sock, $client_side_sock)
  {
    SocketService::socketBind($socket, $server_side_sock);

    while (1) // server never exits
    {
      echo "Ready to receive...\n";
      $buf = SocketService::receiveQuery($socket);
      fwrite(STDOUT, $buf);
      $len = strlen($buf);  // process client query here
      $answer = "Received " . $len . " bytes\n";
      SocketService::sendMessage($socket, $answer, $client_side_sock);

      echo "Request processed\n";
    }
  }
}
