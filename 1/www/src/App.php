<?php

namespace Ahar\Hw4;
use Ahar\Hw4\exceptions\ValidateExceptions;

class App
{
    public function run(): void
    {
        $request = new Request();
        $value = $request->post('string');
        try {
            $validator = new Validator();
            $validator->validate($value);

            $responseMessage = new ResponseMessage(ResponseStatus::OK, 'Все окей');
        } catch (ValidateExceptions $exception) {
            $responseMessage = new ResponseMessage(ResponseStatus::BAD_REQUEST, $exception->getMessage());
        } catch (\Throwable $exception) {
            $responseMessage = new ResponseMessage(ResponseStatus::BAD_REQUEST, $exception->getMessage());
        }

        $response = new Response();
        $response->send($responseMessage);
    }
}
