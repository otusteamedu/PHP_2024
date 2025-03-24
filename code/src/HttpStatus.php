<?php

namespace App;

class HttpStatus
{
    public const OK = 200; // Успешный запрос
    public const CREATED = 201; // Запись создана
    public const NO_CONTENT = 204; // Нет содержимого

    public const BAD_REQUEST = 400; // Неверный запрос
    public const UNAUTHORIZED = 401; // Не авторизован
    public const FORBIDDEN = 403; // Доступ запрещён
    public const NOT_FOUND = 404; // Не найдено

    public const SERVER_ERROR = 500; // Внутренняя ошибка сервера
    public const SERVICE_UNAVAILABLE = 503; // Сервис недоступен
}
