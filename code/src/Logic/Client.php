<?

namespace Kuz\ChatSocket\Logic;

use Exception;

class Client extends Socket
{
  function startSocket($serverFrom)
  {
    while (1) {
      echo "Write to message: ";
      $msg = fgets(STDIN);
      parent::sendMessage($msg, $serverFrom);
      $buf = parent::receiveQuery();
      fwrite(STDOUT, $buf);
    }
  }
}
