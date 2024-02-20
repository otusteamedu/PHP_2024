<?php
declare(strict_types=1);

namespace Hukimato\Code;

use Exception;

class App
{

    /**
     * @throws Exception
     */
    public static function run(): void
    {
        $string = $_POST['string'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            throw new Exception("Only POST allowed");
        }

        if (empty($string)) {
            http_response_code(400);
            throw new Exception("Body param 'string' required");
        }

        if (StringValidator::validateString($string)) {
            http_response_code(200);
            echo "Строка хорошая" . PHP_EOL;
        } else {
            http_response_code(400);
            echo "Строка плохая" . PHP_EOL;
        }
    }
}
