<?

namespace Kuz\ChatSocket\Logic;

use Exception;

class Client
{
  static function acceptQuery($socket, $server_side_sock, $client_side_sock)
  {
    SocketService::socketBind($socket, $client_side_sock);
    while (1) // server never exits
    {
      echo "Write to message: ";
      $msg = fgets(STDIN);

      SocketService::sendMessage($socket, $msg, $server_side_sock);
      $buf = SocketService::receiveQuery($socket);
      fwrite(STDOUT, $buf);
    }
  }
}
