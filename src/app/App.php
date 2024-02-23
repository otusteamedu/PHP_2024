<?php

declare(strict_types=1);

namespace AShutov\Hw4;

class App
{
    public function run(): string
    {
        try {
            $this->validate();

            return 'Всё ok';
        } catch (\Throwable $e) {
            http_response_code(400);

            return 'Всё плохо, ' . $e->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    public function validate(): void
    {
        $string = $_POST['string'] ?? '';
        (new Validator())->check($string);
    }
}
