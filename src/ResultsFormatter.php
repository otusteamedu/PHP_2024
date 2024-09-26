<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

class ResultsFormatter
{
    public function formatResults(?Event $event): string
    {
        if ($event === null) {
            return "Ничего не найдено.\n";
        }

        $conditions = json_encode($event->conditions);
        return "event: {$event->event}, conditions: {$conditions}, priority: {$event->priority}\n";
    }
}
