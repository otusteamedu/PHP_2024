<?php

namespace App\Application\BotCommand;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name        = BotCommandEnum::BotCommandStart->value;
    protected string $description = BotCommandEnum::BotCommandStartDescription->value;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function handle()
    {
        $userFirstName = $this->getUpdate()->message->from->firstName;

        $response = "*$userFirstName, приветствую вас!*" . PHP_EOL;

        $response .= '
        Я - бот для совместного планирования покупок.
        Чтобы я мог составлять список покупок, в который несколько участников могут вносить планируемые покупки - нужно создать группу, добавить в неё других участников, с которыми вы хотите составлять совместный список покупок, добавить @ShoppingTogetherBot с ролью администратора, чтобы я имел доступ к сообщениям в группе. 
        Все участники группы могут писать в чат покупки, которые нужно сделать. Кроме самих покупок в эту группу больше ничего писать не нужно, потому что всё, что будет написано - я буду воспринимать как планируемую покупку.
        Предметы покупок нужно писать в чат без каких-либо команд по одной или несколько в одном сообщении.
        Если одно сообщение содержит несколько позиций, то после каждой позиции нужно поставить точку (пробел не обязателен).
        Чтобы посмотреть все запланированные покупки с указанием имени участника группы, который её внёс и даты, когда это было сделано - выберите команду /show. 
        Чтобы создать чек-лист покупок, в котором кликом по позиции каждый участник группы может удалить сделанную покупку - выберите команду /checklist.
        Конечно вы можете вести список покупок и в одиночку прямо в этом чате, но наверное это будет не так интересно :-)
        Чтобы посмотреть список всех команд - выберите /help.
        Если вы захотите написать моему разработчику - выберите команду /dev.' . PHP_EOL;

        $response .= '
        *Приятных покупок!*';

        $this->replyWithMessage([
            'parse_mode' => BotCommandEnum::ParseModeDefault->value,
            'text'       => $response
        ]);
    }
}
