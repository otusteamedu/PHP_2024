<?php

namespace App\Application\BotCommand\BotCommandEnum;

enum BotCommandEnum: string
{
    case ParseModeDefault                 = 'Markdown';
    case ParseModeHtml                    = 'HTML';
    case CommandSeparator                 = '@';
    case ItemRemove                       = 'remove';
    case PushInPurchase                   = 'купи';
    case PurchaseSeparatorDot             = '.';
    case PurchaseSeparatorComma           = ',';

    case RequestIsProcessing              = 'Выполняю запрос...';

    case BotCommandStart                  = 'start';
    case BotCommandStartDescription       = 'Начать работу с ботом';

    case BotCommandHelp                   = 'help';
    case BotCommandHelpDescription        = 'Получить список доступных команд';

    case BotCommandDev                    = 'dev';
    case BotCommandDevDescription         = 'Обратиться к разработчику';

    case BotCommandCheckList               = 'checklist';
    case BotCommandCheckListDescription    = 'Показать список покупок для просмотра (без кнопок)';

    case BotCommandShopping                = 'shopping';
    case BotCommandShoppingDescription     = 'Начать шоппинг - список покупок с кнопками для удаления позиций';
}
