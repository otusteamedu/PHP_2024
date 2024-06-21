<?php

declare(strict_types=1);

namespace App;

use App\Request\Request;
use App\Validator\BracketBalance;
use App\Validator\NotEmpty;
use App\Validator\OnlyBrackets;
use App\Validator\PostRequest;
use App\Validator\ValidationChain;
use App\Validator\ValidationException;

class App
{
    /**
     * @return void
     */
    public function run(): void
    {
        $request = new Request();

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
        } catch (ValidationException $ex) {
            header('HTTP/1.1 400 Bad request', true, 400);
            echo $ex->getMessage();
            return;
        } catch (\Exception) {
            header('HTTP/1.1 500 Internal server error', true, 500);
            return;
        }

        echo "Everything is Ok";
    }
}
