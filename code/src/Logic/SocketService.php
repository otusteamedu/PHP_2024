<?

namespace Kuz\ChatSocket\Logic;

use Exception;

class SocketService
{
  /**
   * Метод отправляет сообщение сокету
   *
   * @var Socket $socket, 
   * @var string $msg, 
   * @var string $serverFrom
   */
  static function sendMessage($socket, string $msg, string $serverFrom)
  {
    if (!socket_set_nonblock($socket))
      throw new Exception('Unable to set nonblocking mode for socket');

    $len = strlen($msg);
    $bytes_sent = socket_sendto($socket, $msg, $len, 0, $serverFrom);

    if ($bytes_sent == -1)
      throw new Exception('An error occured while sending to the socket');
    else if ($bytes_sent != $len)
      throw new Exception($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
  }

  static function receiveQuery($socket)
  {
    if (!socket_set_block($socket))
      throw new Exception('Unable to set blocking mode for socket');

    $buf = '';
    $from = '';

    $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
    if ($bytes_received == -1)
      throw new Exception('An error occured while receiving from the socket');
    return $buf;
  }

  static function socketBind($socket, string $side_sock)
  {
    if (file_exists($side_sock))
      unlink($side_sock);
    if (!socket_bind($socket, $side_sock)) {
      throw new Exception('Unable to bind to $client_side_sock');
    }
  }
}
