<?php

declare(strict_types=1);

namespace App\Command;

use App\Request\Request;
use App\Response\Response;
use App\Validator\BracketBalance;
use App\Validator\NotEmpty;
use App\Validator\OnlyBrackets;
use App\Validator\PostRequest;
use App\Validator\ValidationChain;
use App\Validator\ValidationException;
use Exception;

class BracketCheck
{
    public function run(Request $request, Response $response): void
    {
        $requestValidationChain = new ValidationChain();
        $requestValidationChain->addValidator(
            new PostRequest()
        );
        $requestValidationChain->setData($request);

        try {
            $requestValidationChain->validate();

            $stringValidationChain = new ValidationChain();
            $stringValidationChain
                ->addValidator(
                    new NotEmpty()
                )
                ->addValidator(
                    new OnlyBrackets()
                )
                ->addValidator(
                    new BracketBalance()
                );
            $stringValidationChain->setData(
                $request->getPost()->offsetGet('string')
            );
            $stringValidationChain->validate();

            $response->setResultCode(200);
            $response->setContent('');
        } catch (ValidationException $ex) {
            $response->setResultCode(400);
            $response->setContent($ex->getMessage());
            return;
        } catch (Exception) {
            $response->setResultCode(500);
        }
    }
}
