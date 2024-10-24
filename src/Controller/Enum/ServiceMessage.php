<?php

declare(strict_types=1);

namespace App\Controller\Enum;

enum ServiceMessage: string
{
    case ServerStarted        = "[Server] Server started \n";
    case WelcomeToChat        = " Welcome to the chat! To stop the chat, type 'chat:stop'";
    case ClientMessage        = '[Client message] ';
    case ServerAnswer         = 'Server received message: ';
    case ReceivedBytes        = '; received bytes: ';
    case ClientStoppedChat    = "[Server] Client stopped the chat \n";
    case ServerStopped        = "[Server] Server has been stopped \n";
    case ClientStarted        = "[Client started] \n";
    case ServerMessage        = '[Server message] ';
    case ClientInvitation     = '[Write your message] ';
    case ClientStopped        = "[Server message] Client stopped the chat, chat has been stopped \n";

    case StoragePostSuccess   = "\nУспешно: добавлена запись в раздел ";
    case StoragePostError     = "\nОшибка: запись не добавлена";
    case StorageGetSuccess    = "\nУспешно: по ключу получена запись ";
    case StorageGetError      = "\nОшибка:  отсутствует запись c ключом ";
    case StorageRemoveSuccess = "\nУспешно: записи удалены";
    case StorageRemoveError   = "\nОшибка: записи не удалены либо отсутствует раздел ";
    case StorageStatusError   = "\nОшибка: отсутствует подключение к хранилищу";

    case ElasticBulkError     = "\nОшибка: такие документы уже загружены в индекс";
    case ElasticBulkSuccess   = "\nУспешно: документы загружены в индекс";
    case ElasticDropSuccess   = "\nУспешно: индекс удалён";

    case ElasticCreateSuccess = "\nУспешно: индекс создан";
    case ElasticCreateError   = "\nОшибка: такой индекс уже существует";
    case ElasticIndexNotFound = "\nОшибка: индекс не найден";

    case ProductLoadSuccess   = "\nУспешно: продукты загружены";
    case ProductLoadError     = "\nОшибка: продукты не загружены";
    case ProductFindError     = "\nОшибка: продукт не найден";
    case ProductUpdateSuccess = "\nУспешно: продукт обновлён";
    case ProductCreateSuccess = "\nУспешно: продукт создан ";
    case ProductCreateError   = "\nОшибка: продукт не создан";
    case ProductRemoveSuccess = "\nУспешно: продукт удалён";
}
