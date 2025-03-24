<?php

namespace App\Application\Observer;

interface SubscriberInterface
{
    public function update(Event $event);
}