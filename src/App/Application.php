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
        $this->processRequest()->send();
    }

    /**
     * @return Response
     */
    private function processRequest(): Response
    {
        try {
            $this->checkRequest();
        } catch (RequestCheckingException $e) {
            return $e->getResponse();
        }

        try {
            (new Validation())->validateBrackets($_POST['string']);
            return Response::createSuccessResponse('Строка корректна!');
        } catch (Exception $e) {
            return Response::createBadRequestResponse($e->getMessage());
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
