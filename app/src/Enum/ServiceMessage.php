<?php

declare(strict_types=1);

namespace App\Enum;

enum ServiceMessage: string
{
  case ServerStarted     = "[Server] Server started \n";
  case WelcomeToChat     = " Welcome to the chat! To stop the chat, type 'chat:stop'";
  case ClientMessage     = '[Client message] ';
  case ServerAnswer      = 'Server received message: ';
  case ReceivedBytes     =  '; received bytes: ';
  case ClientStoppedChat = "[Server] Client stopped the chat \n";
  case ServerStopped     = "[Server] Server has been stopped \n";
  case ClientStarted     = "[Client started] \n";
  case ServerMessage     = '[Server message] ';
  case ClientInvitation  = '[Write your message] ';
  case ClientStopped     = "[Server message] Client stopped the chat, chat has been stopped \n";
}
