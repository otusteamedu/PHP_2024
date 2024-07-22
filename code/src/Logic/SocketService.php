<?

namespace Kuz\ChatSocket\Logic;

interface SocketService
{
  function createSocket();
  function sendMessage($msg, $serverFrom);
  function receiveQuery();
  function socketBind();
}
