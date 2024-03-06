<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\ReadFileException;
use Dotenv\Dotenv;

class App
{
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $data = $this->getList('');
        $validator = new EmailValidator();
        $errors = $validator->validate($data);

        $this->showResult($errors);
    }

    private function getList(string $fileName): array
    {
        $emails = file($fileName, FILE_IGNORE_NEW_LINES);

        if (!$emails) {
            throw new ReadFileException();
        }

        return $emails;
    }

    private function showResult(array $result): void
    {
        foreach ($result as $row) {
            echo $row;
        }
    }
}
