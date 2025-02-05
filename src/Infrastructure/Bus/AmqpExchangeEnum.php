<?php

namespace App\Infrastructure\Bus;

enum AmqpExchangeEnum: string
{
    case ChatUpdate  = 'chat_update';
    case SendMessage = 'send_message';
    case EditMessage = 'edit_message';
}
