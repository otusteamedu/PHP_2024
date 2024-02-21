<?php

declare(strict_types=1);

namespace AlexanderGladkov\App;

use AlexanderGladkov\App\RequestChecking\Exceptions\RequestCheckingException;
use AlexanderGladkov\App\Response\Response;
use AlexanderGladkov\App\Validation\Validation;
use Exception;

class Application
{
    /**
     * @return void
     */
    public function run(): void
    {
        try {
            $this->checkRequest();
        } catch (RequestCheckingException $e) {
            $e->getResponse()->send();
            return;
        }

        try {
            (new Validation())->validateBrackets($_POST['string']);
            Response::createSuccessResponse('Строка корректна!')->send();
        } catch (Exception $e) {
            Response::createBadRequestResponse($e->getMessage())->send();
        }
    }

    /**
     * @throws RequestCheckingException
     */
    private function checkRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new RequestCheckingException(
                Response::createRequestMethodNotAllowedResponse(['POST'])
            );
        }

        $string = $_POST['string'] ?? null;
        if ($string === null) {
            throw new RequestCheckingException(
                Response::createBadRequestResponse('В запросе должен быть параметр "string"!')
            );
        }
    }
}
