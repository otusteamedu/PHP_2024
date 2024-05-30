<?php


namespace App\entities;


class OrderAdmin extends Order
{
    public $statusOptions =  [
        "Создан",
        "Оплачен",
        "В обработке",
        "Отправлен",
        "Выполнен"
        ];

}