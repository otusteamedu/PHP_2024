<?php

namespace App\Models;

class Message
{
    public static function save($message)
    {
        // Здесь можно добавить логику для сохранения сообщений в БД
        file_put_contents('messages.log', $message . PHP_EOL, FILE_APPEND);
    }

    public static function getAll()
    {
        // Здесь можно добавить логику для получения всех сообщений из БД
        return file_exists('messages.log') ? file_get_contents('messages.log') : '';
    }
}