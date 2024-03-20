<?php
declare(strict_types=1);

namespace App;

use App\Response\Error400;
use App\Response\Success;
use App\Validators\RoundBrackets;


final class Validation
{
    const POSTKEY = 'string';
    private array $post;
    private ?Error400 $errorResponse;
    private RoundBrackets $roundBrackets;
    private Success $successResponse;


    public function __construct(
        Error400 $error400,
        RoundBrackets $roundBrackets,
        Success $successResponse
    )
    {
        $this->post = $_POST;
        $this->errorResponse = $error400;
        $this->roundBrackets = $roundBrackets;
        $this->successResponse = $successResponse;
    }

    public function validatePost()
    {
        if (!array_key_exists(self::POSTKEY,$this->post)) {
            $this->errorResponse->get();
            return;
        }

        $string = $this->post[self::POSTKEY];
        $result = $this->roundBrackets->validate($string);
        if ($result) $this->successResponse->get();
        else $this->errorResponse->get();
    }

}

