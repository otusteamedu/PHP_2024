<?php

namespace AlexanderGladkov\Broker\Service\Mail;

interface MailServiceInterface
{
    public function sendMessageSuccessfullyProcessedLetter(string $email, string $messageText): void;
}