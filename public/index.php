<?php

use AlexanderPogorelov\Validator\Emitter;
use AlexanderPogorelov\Validator\Request;
use AlexanderPogorelov\Validator\Response;
use AlexanderPogorelov\Validator\Validator;

require dirname(__DIR__) . '/vendor/autoload.php';

$request = new Request();
$response = new Response();

if (!$request->isPostRequest()) {
    $response
        ->setSuccess(false)
        ->setMessage('Only Post request is allowed')
        ->setStatusCode(405)
        ->setReasonPhrase('Method Not Allowed')
        ->addHeader('Allow', 'POST');
    $emitter = new Emitter($response);
    $emitter->emit();
}

$inputValue = $request->getPostValue('String');

$result = (new Validator())->validateString($inputValue);

$response
    ->setSuccess($result->success)
    ->setMessage($result->message);

if (!$result->success) {
    $response
        ->setStatusCode(400)
        ->setReasonPhrase('Bad Request');
}

$emitter = new Emitter($response);
$emitter->emit();
