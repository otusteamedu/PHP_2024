<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Validator;

class App
{
    private Request $request;
    private Response $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run(): void
    {
        $this->validateMethod();
        $this->validateString();
    }

    private function validateMethod(): void
    {
        if ($this->request->isPostRequest()) {
            return;
        }

        $this->response
            ->setSuccess(false)
            ->setMessage('Only Post request is allowed')
            ->setStatusCode(405)
            ->setReasonPhrase('Method Not Allowed')
            ->addHeader('Allow', 'POST');
        $emitter = new Emitter($this->response);
        $emitter->emit();
    }

    private function validateString(): void
    {
        $inputValue = $this->request->getPostValue('String');

        $result = (new Validator())->validateString($inputValue);

        $this->response
            ->setSuccess($result->success)
            ->setMessage($result->message);

        if (!$result->success) {
            $this->response
                ->setStatusCode(400)
                ->setReasonPhrase('Bad Request');
        }

        $emitter = new Emitter($this->response);
        $emitter->emit();
    }
}
