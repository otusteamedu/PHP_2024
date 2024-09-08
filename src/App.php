<?php

namespace PenguinAstronaut\App;

use Exception;
use PenguinAstronaut\App\Exceptions\EmptyStringException;
use PenguinAstronaut\App\Exceptions\InvalidStringException;

class App
{
    public function run()
    {
        $httpResponseCode = 200;
        $httpResponseMessage = 'All Ok';

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $validator = new Validator();
                $validator->validateString($_POST['string'] ?? '');
            }
        } catch (EmptyStringException | InvalidStringException $e) {
            $httpResponseCode = 400;
            $httpResponseMessage = 'Invalid or empty input data';
        } catch (Exception $e) {
            $httpResponseCode = 500;
        } finally {
            http_response_code($httpResponseCode);
            echo $httpResponseMessage;
        }
    }
}
