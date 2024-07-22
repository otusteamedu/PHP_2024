<?

namespace Kuz\ChatSocket\Logic;

class Server extends Socket
{
  function startSocket($serverFrom)
  {
    while (1) {
      echo "Ready to receive...\n";
      $buf = parent::receiveQuery();
      fwrite(STDOUT, $buf);
      $len = strlen($buf);  // process client query here
      $answer = "Received " . $len . " bytes\n";
      parent::sendMessage($answer, $serverFrom);
    }
  }
}
