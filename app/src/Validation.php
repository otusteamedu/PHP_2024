<?php
declare(strict_types=1);

namespace App;

use App\Response\Error400;
use App\Response\Success;
use App\Validators\RoundBrackets;


final class Validation
{

    private array $_post;
    private string $_postKey = 'string';
    private ?Error400 $_errorResponse;
    private RoundBrackets $_roundBrackets;
    private Success $_successResponse;


    public function __construct()
    {
        $this->_post = $_POST;
        $this->_errorResponse = new Error400();
        $this->_roundBrackets = new RoundBrackets();
        $this->_successResponse = new Success();
    }

    public function validatePost():void
    {
        if (array_key_exists($this->_postKey,$this->_post)) {

            $string = $this->_post[$this->_postKey];
            $result = $this->_roundBrackets->validate($string);
            if ($result) $this->_successResponse->getSuccess();
            else $this->_errorResponse->getError400();;
        } else {
            $this->_errorResponse->getError400();
        }
    }

}

