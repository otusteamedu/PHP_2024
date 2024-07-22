<?

namespace Kuz\ChatSocket\Logic;

use Exception;

class Socket implements SocketService
{
  protected $side_sock;
  protected $socket;
  function __construct($side_sock)
  {
    $this->side_sock = $side_sock;
  }
  function createSocket()
  {
    if (!extension_loaded('sockets')) {
      throw new Exception("The sockets extension is not loaded");
    }

    $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

    if (!$socket) {
      throw new Exception('Unable to create AF_UNIX socket');
    }
    $this->socket = $socket;
  }

  function socketBind()
  {
    if (file_exists($this->side_sock))
      unlink($this->side_sock);
    if (!socket_bind($this->socket, $this->side_sock)) {
      throw new Exception('Unable to bind to $client_side_sock');
    }
  }

  function sendMessage($msg, $serverFrom)
  {
    if (!socket_set_nonblock($this->socket))
      throw new Exception('Unable to set nonblocking mode for socket');
    $len = strlen($msg);
    $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, $serverFrom);
    if ($bytes_sent == -1)
      throw new Exception('An error occured while sending to the socket');
    else if ($bytes_sent != $len)
      throw new Exception($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
  }

  function receiveQuery()
  {
    if (!socket_set_block($this->socket))
      throw new Exception('Unable to set blocking mode for socket');

    $buf = '';
    $from = '';

    $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
    if ($bytes_received == -1)
      throw new Exception('An error occured while receiving from the socket');
    return $buf;
  }
}
