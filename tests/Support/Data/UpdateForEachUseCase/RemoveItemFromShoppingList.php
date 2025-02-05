<?php

namespace Support\Data\UpdateForEachUseCase;

class RemoveItemFromShoppingList
{
    public static function getUpdateArray(array $idArray): array
    {
        return [
            "update_id" => -1,
            "callback_query" => [
                "id" => "334218539855687899",
                "from" => [
                    "id" => 77816317,
                    "is_bot" => false,
                    "first_name" => "Евгений",
                    "username" => "JohnMontigomo",
                    "language_code" => "ru"
                ],
                "message" => [
                    "message_id" => -1,
                    "from" => [
                        "id" => 8150990981,
                        "is_bot" => true,
                        "first_name" => "ShoppingTogetherBot",
                        "username" => "ShoppingTogetherBot"
                    ],
                    "chat" => [
                        "id" => -1002453281390,
                        "title" => "Покупки",
                        "type" => "supergroup"
                    ],
                    "date" => 1000000000,
                    "text" => "Список покупок =>",
                    "entities" => [
                        [
                            "offset" => 0,
                            "length" => 15,
                            "type" => "bold"
                        ]
                    ],
                    "reply_markup" => [
                        "inline_keyboard" => [
                            [[
                                "text" => "test purchase one",
                                "callback_data" => "remove@$idArray[0]"
                            ]],
                            [[
                                "text" => "test purchase two",
                                "callback_data" => "remove@$idArray[1]"
                            ]],
                        ]
                    ]
                ],
                "chat_instance" => "513971021589410453",
                "data" => "remove@$idArray[0]"
                ]
            ];
    }

    public static function getUpdateString(array $idArray): string
    {
        return json_encode(self::getUpdateArray($idArray));
    }

    public static function getUpdateArrayForObject(array $idArray): array
    {
        return ['data'  => self::getUpdateArray($idArray)];
    }
}
