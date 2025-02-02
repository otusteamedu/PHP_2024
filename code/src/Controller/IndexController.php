<?php

namespace DudkinIv\TestPackage\Controller;

use DudkinIv\TestPackage\Service\Validator;

class IndexController implements Controller
{
    protected Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function getAction()
    {
        return "Не туда пришли. Попробуйте метод POST";
    }

    public function postAction()
    {
        $string = $_POST['emails'];

        if ($this->validator->validateEmails($string)) {
            return "Все хорошо";
        } else {
            http_response_code(400);
            return "все плохо";
        }
    }
}