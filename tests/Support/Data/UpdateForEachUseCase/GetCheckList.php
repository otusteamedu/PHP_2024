<?php

namespace Support\Data\UpdateForEachUseCase;

class GetCheckList
{
    public static function getUpdateArray(): array
    {
        return [
            "update_id" => -1,
            "message" => [
                "message_id" => -1,
                "from" => [
                    "id" => 77816317,
                    "is_bot" => false,
                    "first_name" => "Евгений",
                    "username" => "JohnMontigomo",
                    "language_code" => "ru"
                ],
                "chat" => [
                    "id" => -1002453281390,
                    "title" => "Покупки",
                    "type" => "supergroup"
                ],
                "date" => 1000000000,
                "text" => "/checklist@ShoppingTogetherBot",
                "entities" => [
                    [
                        "offset" => 0,
                        "length" => 25,
                        "type" => "bot_command"
                    ]
                ]
            ]
        ];
    }

    public static function getUpdateString(): string
    {
        return json_encode(self::getUpdateArray());
    }

    public static function getUpdateArrayForObject(array $idArray = null): array
    {
        return ['data' => self::getUpdateArray()];
    }
}
