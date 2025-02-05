<?php

namespace App\Application\TextMessageEnum;

enum TextMessageEnum: string
{
    case CheckList             = 'Список покупок для просмотра:';
    case ShoppingList          = 'Список покупок для шоппинга:';
    case ShoppingListEmpty     = 'У вас нет запланированных покупок';
    case ShoppingListCompleted = 'Поздравляю! Вы купили всё, что запланировали!';
}
